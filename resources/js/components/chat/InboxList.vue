<template>
    <div>
        <div v-if="loading">
            <loading-inbox-list></loading-inbox-list>
        </div>
        <template v-if="chatRooms.data">
            <a v-for="chatRoom in chatRooms.data" class="inbox-item d-md-flex py-3 px-md-4 px-2" style="gap: 1.2rem; cursor: pointer;" v-bind:key="chatRoom.index" :href="`/chat/${chatRoom.id}`">
                <div class="chat-img-wrapper">
                    <img class="chat-user-img" :src="chatRoom.opponent.avatar_url" :alt="chatRoom.customer_name">
                </div>
                <div class="chat-info-wrapper">
                    <div class="chat-name">{{ chatRoom.opponent.name }}</div>
                    <div style="font-size: 0.8rem" class="d-md-block d-none">{{ chatRoom.last_message_at }}</div>
                </div>
            </a>
        </template>
    </div>
</template>

<script>
import LoadingInboxList from "./LoadingInboxList.vue";
export default {
    components: {LoadingInboxList},
    props: ['user'],
    data() {
        return {
            chatRooms: [],
            loading: false
        }
    },

    created() {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
        this.fetchChatRooms();
    },

    methods: {
        fetchChatRooms() {
            this.loading = true;
            axios.get('/api/chatrooms')
                .then(res => {
                    this.chatRooms = res.data;
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                })
        }
    }
}
</script>