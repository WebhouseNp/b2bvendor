<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chatbox</title>
    <script src="https://unpkg.com/tailwindcss-jit-cdn"></script>
</head>
<body>
    <div id="app" class="max-w-screen-sm mx-auto p-5">
        <div class="mb-5">
            <div v-for="(message, index) in messages" v-bind:key="index" class="flex space-x-3 bg-gray-50 p-3 rounded hover:shadow-sm mb-3">
                <div>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    @{{ message.message }}
                </div>
            </div>
            <div>
                <button v-on:click="clearConversation" type="button" class="text-red-500 text-xs ">Clear Conversation</button>
            </div>
        </div>

        <form v-on:submit.prevent="sendMessage" class="w-full ">
            <div class="flex items-center">
                <input v-model="message" type="text" class="border-gray-200 flex-grow">
                <button type="submit" class="py-2 px-4 bg-indigo-600 text-gray-50">Send</button>
            </div>
        </form>
    </div>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.js" integrity="sha512-4TDSPIWADGfNTk4rziE+CBjCocreW3n95H2I9Nscxw5KE1akjXul8uf18U7B5VmqDNWCSHqKC78CpdiqEfMgcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.common.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/socket.io-client@2.1.1/dist/socket.io.js"></script>
    <script src="https://github.com/glitterlip/echoexample/blob/master/public/js/echocompiled.js"></script>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('def24be273f469943a0f', {
            cluster: 'ap2'
        });

        const app = new Vue({
            el: '#app'
            , data: {
                message: ''
                , messages: []
            , },

            created() {
                this.loadMessages();
            },

            methods: {
                sendMessage() {
                    // event(new NewMessageEvent('hello world'));
                    axios.post('/api/messages', {
                        message: this.message
                    }).then(response => {
                        console.log(response.data);
                    }).catch(error => {
                        console.log(error);
                    }).then(() => {
                        this.loadMessages()
                        this.message = ''
                    });
                },

                loadMessages() {
                    axios.get('/api/messages').then(
                        (response) => {
                            console.log(response);
                            this.messages = response.data;
                        });
                }
                ,
                clearConversation() {
                    axios.delete('/api/messages').then(
                        (response) => {
                            console.log(response.data.message);
                            this.messages = [];
                        });
                }
            }
        })

        var channel = pusher.subscribe('chat-channel');

channel.bind('Modules\\Message\\Events\\NewMessageEvent', function(data) {
    console.log('new event listened');
    // this.loadMessages() 
    console.log(data);
    // app.messages.push(JSON.stringify(data));
    app.loadMessages();
});

    </script>
</body>
</html>
