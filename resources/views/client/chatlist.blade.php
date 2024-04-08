<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat List :: Live Chat Web Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/client/style.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js')}}"></script>
</head>

<body>
    <div class="container">
        <h2>Your Chats</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Chat Id</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Open Time</th>
                        <th>Status</th>
                        <th>Admin Reply</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chats as $chat)
                    <tr>
                        <td>{{$chat->id}}</td>
                        <td>{{$chat->category}}</td>
                        <td>{{$chat->message}}</td>
                        <td>{{ $chat->created_at->format('M d, Y H:i:s') }}</td>
                        <td>{{ $chat->status }}</td>
                        <td>{{ $chat->admin_reply ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
       
        Echo.private('MessageUpdate').listen('ChatEvent', (data) => {
        if ({{ auth()->id() }} === data.chat.user_id) {
        console.log(data);
        }  
        });
        Echo.private('one-to-one').listen('MessageEvent', (data) => {  
        console.log(data);
        });
    </script>
    <script>
    </script>
</body>

</html>