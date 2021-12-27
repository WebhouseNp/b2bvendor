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
</head>
<body>
    <div class="messaging-page">
        <div class="inbox-wrapper py-2 px-4">
            <div class="p-2">
                <h4>Recent</h4>
            </div>
            {{-- <div class="p-2">
                <form action="">
                    <input type="text" placeholder="Search">
                </form>
            </div> --}}
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
        <div class="conversation-wrapper">
            <div class="conversation-header px-4 py-3 bg-light">
                <h5 class="h5-responsive">John Doe</h5>
            </div>
            <div class="conversation py-5 px-4">
                <div class="message outgoing">
                    <div>Test which is a new approach to have all
                        solutions</div>
                    {{-- <span class="date-time"> 11:01 AM | June 9</span> --}}
                </div>
                <div class="message incomming">
                    <div>Test which is a new approach to have all
                        solutions</div>
                    {{-- <span class="date-time"> 11:01 AM | June 9</span> --}}
                </div>
            </div>
            <div class="conversation-creator px-4 py-3">
                <form action="" class="message-compose-form mb-0">
                    {{-- <input type="file"> --}}
                    <input type="text" class="py-3 px-4" placeholder="Type a message...">
                    <button type="submit" class="border"><i class="fa fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>
