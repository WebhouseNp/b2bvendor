<template>
  <div class="conversation-wrapper">
    <div class="conversation-header px-4 py-3 border-bottom">
      <div class="d-flex align-items-center" style="gap: 1rem">
        <div :class="{ 'text-success': isOpponentActive, 'text-danger': !isOpponentActive }"><i class="fa fa-circle" aria-hidden="true"></i></div>
        <h6 class="text-capitalize" v-if="opponentUser">
          {{ opponentUser.name }}
        </h6>
        <div class="ml-auto">
            <router-link :to="{ name:'messages', params: {chatRoomId: this.chatRoom.id } }" class="btn btn-link text-white p-0 mr-2"><i class="fa fa-expand"></i></router-link>
            <button type="button" @click="closeChatPopup()" class="btn btn-link text-white p-0"><i class="fa fa-times"></i></button>
          </div>
      </div>
    </div>
    <div class="conversation py-5 px-4" v-chat-scroll="{ always: false, smooth: true, scrollonremoved: true, smoothonremoved: false }" @v-chat-scroll-top-reached="loadOlderMessages">
      <div v-if="loadingMessages" class="mb-2 d-flex justify-content-center" role="status">
        <div class="loader"></div>
      </div>
      <div v-for="(message, index) in messages" :key="index" class="d-flex">
        <message-block :message="message" :user="user"></message-block>
      </div>
      <div v-for="message in queueMessages" :key="message.ts" class="d-flex my-1">
        <div class="message outgoing">
          x
          <div class="bloc text-block">{{ message.message }}</div>
        </div>
      </div>
      <div class="my-2">
        <div v-show="typing" class="chat-bubble">
          <div class="typing">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="conversation-creator px-md-2 py-2">
      <form @submit.prevent="sendMessage" class="message-compose-form border mb-0">
        <label class="bg-file px-md-2 d-inline-flex align-items-center">
          <input type="file" @change="sendFile" style="display: none" />
          <i class="fa fa-plus-circle"></i>
        </label>
        <input v-model="newMessage" type="text" class="py-md-2 px-md-2" @keyup="sendTypingEvent" placeholder="Enter text here..." />
        <button type="submit" class="btn btn-send px-md-2"><i class="fa fa-paper-plane"></i></button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import MessageBlock from "./MessageBlock.vue";
import Swal from "sweetalert2";

export default {
  components: { MessageBlock },
  name: "ChatBox",
  props: ["user", "vendorUserId", "chatRoom"],
  data() {
    return {
      newMessage: "",
      messages: [],
      queueMessages: [],
      activeUsers: [],
      opponentUser: null,
      typing: false,
      loadingMessages: false,
    };
  },
  async created() {
    axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("token");
    // this.user = this.$store.getters['user/user'];
    // Get or create chat room
    // await this.getOrCreateChatRoom();
    // Join the chat room
    await this.joinChatRoom();
    // Fetch opponent user
    this.fetchOpponentUser();
    // Load last messages
    this.loadLastMessages();

    // Reset typing status peridiocally
    setInterval(() => {
      this.typing = false;
    }, 2000);
  },
  methods: {
    fetchOpponentUser() {
      this.opponentUser = this.chatRoom.customer_user;
    },

    joinChatRoom() {
      window.channel = window.Echo.join("chat-channel-" + this.chatRoom.id)
        .here((users) => {
          this.activeUsers = users;
          console.log(users);
        })
        .joining((user) => {
          this.activeUsers.push(user);
        })
        .leaving((user) => {
          this.activeUsers = this.activeUsers.filter((u) => u.id !== user.id);
        })
        .listen(".new-message", (event) => {
          this.messages.push(event.message);
        })
        .listenForWhisper("typing", (e) => {
          this.typing = true;
          console.log(e);
        })
        .error((error) => {
          console.error(error);
        });
    },

    sendTypingEvent() {
      window.channel.whisper("typing", { user_id: this.user.id });
      console.log("Whispering...");
    },

    sendMessage() {
      this.newMessage = this.newMessage.trim();
      if (!this.newMessage) return;
      let ts = Date.now();
      this.queueMessages.push({
        message: this.newMessage,
        type: "text",
        ts: ts,
      });

      let data = {
        message: this.newMessage,
        ts: ts,
      };
      this.newMessage = "";

      axios
        .post(`/api/messages/${this.chatRoom.id}`, data)
        .then((response) => {
          this.messages.push(response.data.data);
          this.queueMessages.forEach((element) => {
            if (element.ts == response.data.ts) {
              this.queueMessages.splice(this.queueMessages.indexOf(element), 1);
            }
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    sendFile(e) {
      let file = e.target.files[0];
      let formData = new FormData();
      formData.append("file", file);
      formData.append("type", "file");
      axios({
        method: "POST",
        url: `/api/messages/${this.chatRoom.id}`,
        data: formData,
        headers: {
          "X-Socket-Id": window.Echo.socketId(),
          "Content-Type": "multipart/form-data",
        },
      })
        .then((response) => {
          this.messages.push(response.data.data);
        })
        .catch((error) => {
          console.log(error);
          if (error.response.status == 422) {
            Swal.fire({
              title: "OOPS",
              text: "This file type is not allowed.",
              icon: "error",
            });
          }
        });
    },

    // load the last messages during initialization
    async loadLastMessages() {
      this.loadingMessages = true;
      await axios
        .get("/api/chats/" + this.chatRoom.id + "/messages")
        .then((response) => {
          Object.values(response.data.data).forEach((message) => {
            this.messages.push(message);
          });
          this.loadingMessages = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    loadOlderMessages() {
      this.loadingMessages = true;
      console.log("loading older messages");
    },
  },

  computed: {
    isOpponentActive() {
      for (let [key, user] of Object.entries(this.activeUsers)) {
        if (user.id == this.opponentUser.id) {
          return true;
        }
      }
      return false;
    },
  },
};
</script>