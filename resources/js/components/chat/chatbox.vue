<template>
  <div>
    <div class="chat-conversation-box">
      <div class="chat-head">
                  <div class="chat-about">
                    <h6 class="mb-0">{{ opponentUserName }}</h6>
                  </div>
      </div>
      <div class="chat-body px-2">
                  <div v-for="(message, index) in messages" :key="index" class=" d-flex my-2">
                    <div class="message" v-bind:class="{ 'outgoing-message': isOutgoing(message), 'incomming-message': !isOutgoing(message) }">{{ message.message }}</div>
                  </div>
      </div>
      <div class="chat-foot">
        <form @submit.prevent="sendMessage">
                  <div class="mb-0 input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-plus-circle"></i>
                        <input type="file" class="select-file" />
                      </span>
                    </div>
                    <input v-model="newMessage" type="text" class="form-control" placeholder="Enter text here..." />
                    <div class="input-group-prepend">
                      <button class="input-group-text"><i class="fa fa-send"></i></button>
                    </div>
                  </div>
                </form>
      </div>
    </div>

    <!-- MAIN SECTION -->
    <div class="container d-none">
      <div class="clearfix row">
        <div class="col-lg-12">
          <div class="card chat-app">
            <div class="chat">
              <div class="clearfix chat-header">
                <div class="row">
                  <div class="mx-1 mt-1 chat-wrapper">
                    <span>A</span>
                  </div>
                  <div class="chat-about">
                    <h6 class="mb-0">{{ opponentUserName }}</h6>
                    <!-- <small>Last seen: 2 hours ago</small> -->
                  </div>
                </div>
              </div>
              <div class="chat-history" id="messageBody">
                <ul class="overflow-auto m-b-0">
                  <li v-for="(message, index) in messages" class="clearfix" :key="index">
                    <div class="message" v-bind:class="{ 'float-right my-message': isOutgoing(message), 'other-message': !isOutgoing(message) }">{{ message.message }}</div>
                  </li>
                  <!-- <li class="clearfix">
                    <div class="message other-message">Are we meeting today?</div>
                  </li> -->
                </ul>
              </div>
              <div class="clearfix chat-message">
                <form @submit.prevent="sendMessage">
                  <div class="mb-0 input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fa fa-plus-circle"></i>
                        <input type="file" class="select-file" />
                      </span>
                    </div>
                    <input v-model="newMessage" type="text" class="form-control" placeholder="Enter text here..." />
                    <div class="input-group-prepend">
                      <button class="input-group-text"><i class="fa fa-send"></i></button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END MAIN SECTION -->
  </div>
</template>

<script>
import Echo from "laravel-echo";
import axios from "axios";
export default {
  name: "ChatBox",
  props: ["user", "vendorUserId", "customerUserId"],
  data() {
    return {
      authEndpoint: process.env.MIX_ECHO_AUTH_ENDPOINT,
      chatRoom: null,
      newMessage: "",
      messages: [],
      opponentUserName: null
    };
  },
  async created() {
    this.user = this.$store.getters['user/user'];
    // Get or create chat room
    await this.getOrCreateChatRoom();
    // Join the chat room
    await this.joinChatRoom();
    // Fetch opponent user
    this.fetchOpponentUser();
    // Load last messages
    this.loadLastMessages();
  },
  methods: {
    fetchOpponentUser() {
        this.opponentUserName = this.chatRoom.customer_name;
    },

    async getOrCreateChatRoom() {
      await axios
        .get("/api/chats/start", {
          params: {
            vendor_user_id: this.vendorUserId,
            customer_user_id: this.customerUserId,
          },
        })
        .then((res) => {
          console.log(res.data.data);
          this.chatRoom = res.data.data;
          console.log("chatroom received");
        });
    },

    joinChatRoom() {
      window.Echo = new Echo({
        broadcaster: "pusher",
        key: process.env.MIX_PUSHER_APP_KEY,
        // authEndpoint: this.authEndpoint,
        wsHost: process.env.MIX_PUSHER_WSHOST,
        wsPort: process.env.MIX_PUSHER_WSPORT,
        forceTLS: false,
        disableStats: false,
        authorizer: (channel) => {
          return {
            authorize: (socketId, callback) => {
              fetch(this.authEndpoint, {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                  Authorization: "Bearer " + localStorage.getItem("token"),
                },
                body: JSON.stringify({
                  socket_id: socketId,
                  channel_name: channel.name,
                }),
              })
                .then((response) => response.json())
                .then((data) => {
                  callback(false, data);
                })
                .catch((error) => {
                  callback(true, error);
                });
            },
          };
        },
      });

      window.Echo.private("chat-channel-" + this.chatRoom.id).listen(".new-message", (event) => {
        console.log("event-listened");
        console.log(event);
        this.messages.push(event.data.message);
      });
    },

    sendMessage() {
      axios
        .post("/api/messages", {
          chat_room_id: this.chatRoom.id,
          message: this.newMessage,
        })
        .then((response) => {
          console.log(response.data);
          this.newMessage = "";
        })
        .catch((error) => {
          console.log(error);
        })
        .then(() => {
          // this.newMessage = "";
        });
    },

    loadMessages() {
      axios
        .get("/api/messages", {
          params: {
            chat_room_id: this.chatRoom.id,
          },
        })
        .then((response) => {
          console.log(response.data);
          this.messages = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // load the last messages during initialization
    loadLastMessages() {
      axios
        .get("/api/chats/" + this.chatRoom.id + "/messages")
        .then((response) => {
          console.log(response.data);
          Object.values(response.data.data).forEach((message) => {
            this.messages.push(message);
          });
        })
        .catch((error) => {
          console.log(error);
        });
    },

    // check if is outgoing message
    isOutgoing(message) {
      if (!this.user) {
        console.log("No logged in user's info");
        return false;
      }
      return message.sender_id == this.user.id ? true : false;
    },
  },
};
</script>

<style scoped>
.chat-conversation-box {
  display: flex;
  flex-direction: column;
  height: 350px;
  background-color: #fff;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}
   
.chat-conversation-box  .chat-head {
  background-color: #1e76bd;
  color: #fff;
  padding: 10px 15px;
  border-top-left-radius: 4px;
  border-top-right-radius: 4px;
}
.chat-conversation-box .chat-body {
  flex-grow: 1;
}

.chat-conversation-box .message {
  padding: 8px 10px;
  border-radius: 5px;
  }
.chat-conversation-box .message.incomming-message {
  background: #3b82f6;
  color:white; 

}
.chat-conversation-box .message.outgoing-message {
  background: #cbd5e1;
  color:#1e293b; 
  margin-left: auto;
  }

  .chat-conversation-box .chat-foot {
}

</style>