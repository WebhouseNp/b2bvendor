<template>
    <div>
        <div v-if="loading">
            <loading-inbox-list></loading-inbox-list>
        </div>
        <div v-if="chatRooms.data">
            <div v-for="chatRoom in chatRooms.data" class="inbox-item d-flex" style="gap: 1.2rem;" v-bind:key="chatRoom.index">
                <div>
                    <img class="chat-user-img" :src="chatRoom.opponent.avatar_url" :alt="chatRoom.customer_name">
                </div>
                <div>
                    <div>{{ chatRoom.opponent.name }}</div>
                    <div style="font-size: .8rem;">Dec 25</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LoadingInboxList from "./LoadingInboxList.vue";
export default {
    components: [LoadingInboxList],
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