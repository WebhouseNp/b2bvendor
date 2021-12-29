<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Chat</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/chat.css">
    <script>
        localStorage.setItem('token', "{{ auth()->user()->api_token }}");
    </script>
</head>
<body>
    <div id="app" class="messaging-page">
        <div class="inbox-wrapper py-2 px-4">
            <div class="p-2">
                <h4>Recent</h4>
            </div>
            <div class="inbox-list">
                {{-- active_chat --}}
                @foreach ($chatRooms as $chatRoom)
                <div class="inbox-item d-flex" style="gap: 1.2rem;">
                    <div>
                        <img class="chat-user-img" src="https://ptetutorials.com/images/user-profile.png" alt="{{ $chatRoom->customerUser->name }}">
                    </div>
                    <div>
                        <div>{{ $chatRoom->customerUser->name }}</div>
                        <div style="font-size: .8rem;">Dec 25</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <chatbox :user="{{ $user }}" :vendor-user-id="{{ auth()->id() }}" :chat-room="{{ $activeChatRoom }}"></chatbox>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
