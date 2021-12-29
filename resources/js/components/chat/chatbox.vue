<template>
  <div class="conversation-wrapper">
    <div class="conversation-header px-4 py-3 bg-light">
      <div class="d-flex align-items-center" style="gap: 1rem;">
          <div :class="{ 'text-success': isOpponentActive, 'text-danger': !isOpponentActive }"><i class="fa fa-circle" aria-hidden="true"></i></div>
          <h5 class="h5-responsive text-capitalize" v-if="opponentUser">
            {{ opponentUser.name }}
          </h5>
      </div>
    </div>
    <div class="conversation py-5 px-4"  v-chat-scroll="{always: false, smooth: true, scrollonremoved:true, smoothonremoved: false}" @v-chat-scroll-top-reached="loadOlderMessages">
        <div v-if="loadingMessages" class="mb-2 d-flex justify-content-center" role="status">
          <div class="loader"></div>
        </div>
        <div v-for="(message, index) in messages" :key="index" class="message" v-bind:class="{ 'outgoing': isOutgoing(message), 'incomming': !isOutgoing(message) }">
            <div>{{ message.message }}</div>
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
    <div class="conversation-creator px-4 py-3">
        <form @submit.prevent="sendMessage" class="message-compose-form mb-0">
            <input type="text"  v-model="newMessage" class="py-3 px-4" @keyup="sendTypingEvent" placeholder="Type a message...">
            <button type="submit" class="border"><i class="fa fa-paper-plane"></i></button>
        </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "ChatBox",
  props: ["user", "vendorUserId", "chatRoom"],
  data() {
    return {
      newMessage: "",
      messages: [],
      activeUsers: [],
      opponentUser: null,
      typing: false,
      loadingMessages: false,
    };
  },
  async created() {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
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

    // async getOrCreateChatRoom() {
    //   await axios
    //     .get("/api/chats/start", {
    //       params: {
    //         vendor_user_id: this.vendorUserId,
    //         customer_user_id: this.customerUserId,
    //       },
    //     })
    //     .then((res) => {
    //       console.log(res.data.data);
    //       this.chatRoom = res.data.data;
    //     });
    // },

    joinChatRoom() {
        window.channel = window.Echo.join("chat-channel-" + this.chatRoom.id)
         .here((users) => {
           this.activeUsers = users;
           console.log(users);
          })
          .joining(user => {
            this.activeUsers.push(user);
          })
          .leaving(user => {
            this.activeUsers = this.activeUsers.filter(u => u.id !== user.id);
          })
          .listen(".new-message", (event) => {
              console.log("event-listened");
              console.log(event);
              this.messages.push(event.message);
          })
          .listenForWhisper('typing', (e) => {
            this.typing = true;
          })
          .error((error) => {
              console.error(error);
          });
    },

    sendTypingEvent() {
       window.channel.whisper('typing', {user_id: this.user.id});
    },

    sendMessage() {
        this.messages.push({
                chat_room_id: this.chatRoom.id,
                sender_id: this.user.id,
                message: this.newMessage,
                read_at: null,
                type: 'text',
                created_at: new Date(),
        });

        axios
        .post("/api/messages", {
          chat_room_id: this.chatRoom.id,
          message: this.newMessage,
        })
        .then((response) => {
          this.newMessage = "";
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // load the last messages during initialization
    async loadLastMessages() {
      this.loadingMessages = true;
      await axios
        .get("/api/chats/" + this.chatRoom.id + "/messages")
        .then((response) => {
          console.log(response.data);
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
      console.log('loading older messages');
    },

    // check if is outgoing message
    isOutgoing(message) {
      return message.sender_id == this.user.id ? true : false;
    },
  },

  computed: {
    isOpponentActive() {
       for(let [key, user] of Object.entries(this.activeUsers)){
         if (user.id == this.opponentUser.id) {
           return true;
         }
       }
       return false;
    },
  }
};
</script>