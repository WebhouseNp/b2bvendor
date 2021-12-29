<template>
  <div class="conversation-wrapper">
    <div class="conversation-header px-4 py-3 bg-light">
        <h5 class="h5-responsive">{{ opponentUserName }}</h5>
    </div>
    <div class="conversation py-5 px-4" ref="chatBody">
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
        <div class="scroll-element"></div>
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
      opponentUserName: null,
      typing: false
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
        this.opponentUserName = this.chatRoom.customer_user.name;
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
        .listen(".new-message", (event) => {
            console.log("event-listened");
            console.log(event);
            this.messages.push(event.message);
            this.scrollToLast();
        })
        .listenForWhisper('typing', (e) => {
          this.typing = true;
          this.scrollToLast();
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
      await axios
        .get("/api/chats/" + this.chatRoom.id + "/messages")
        .then((response) => {
          console.log(response.data);
          Object.values(response.data.data).forEach((message) => {
            this.messages.push(message);
          });
          this.scrollToLast();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // check if is outgoing message
    isOutgoing(message) {
      return message.sender_id == this.user.id ? true : false;
    },

  // Fix scroll to bottom
    scrollToLast() {
      console.log("scrollToLast");
      this.$nextTick(() => this.$refs.chatBody.lastElementChild.scrollIntoView({behavior: "smooth"}));
    },    
  },
};
</script>