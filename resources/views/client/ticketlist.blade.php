<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket List :: Live Chat Web Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/client/style.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js')}}"></script>
</head>

<body>
    <div class="container">
        <a class="btn btn-success my-3" type="button" href="{{route('user.raiseTicket')}}">Raise Ticket</a>
        <h2>Your All Tickets</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ticket Id</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Open Time</th>
                        <th>Status</th>
                        <th>Last Admin Reply</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>{{$ticket->id}}</td>
                        <td>{{$ticket->category}}</td>
                        <td>{{$ticket->message}}</td>
                        <td>{{$ticket->created_at->format('M d, Y H:i:s') }}</td>
                        <td>{{$ticket->status }}</td>
                        <td>{{$ticket->admin_reply ?? 'N/A' }}</td>
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