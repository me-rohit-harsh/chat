<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Admin || Oxyclouds</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js')}}"></script>
</head>

<body>

    <div class="container-fluid">
        <div class="card shadow p-2 ">
            <div class="row">
                <!-- Left Panel for Live Chats List -->
                <div class="col-md-4 ">
                    <div class="card ">
                        <div class="card-header bg-info text-white">
                            <strong>Live Chats</strong>
                        </div>
                        <div class="card-header bg-info text-white">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search by User/Status"
                                    id="searchInput">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterBtn"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <form id="statusForm" method="POST" action="{{ route('admin.chat.post') }}">
                                    @csrf
                                    <ul id="statusDropdown" class="dropdown-menu" aria-labelledby="filterBtn">
                                        <li><a type="submit" class="dropdown-item"
                                                href="{{route('admin.chat')}}">All</a></li>
                                        <li><button type="submit" class="dropdown-item text-success" name="status"
                                                value="open">Open</button></li>
                                        <li><button type="submit" class="dropdown-item text-primary" name="status"
                                                value="in process">In
                                                process</button></li>
                                        <li><button type="submit" class="dropdown-item text-danger" name="status"
                                                value="closed">Closed</button></li>
                                        <!-- Add more status options as needed -->
                                    </ul>
                                </form>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush live-chats " id="chatList">


                            <!-- Chat Item 1 -->
                            <ul class="list-group">
                                @foreach($chats as $chat)
                                <li class="list-group-item" id="chat{{$chat->id}}">
                                    <a href="{{ route('admin.chat.show', ['chat_id' => $chat->id]) }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                @php
                                                $departmentColor = '';
                                                switch ($chat->department) {
                                                case 'sales':
                                                $departmentColor = 'bg-success';
                                                break;
                                                case 'support':
                                                $departmentColor = 'bg-primary';
                                                break;
                                                case 'technical':
                                                $departmentColor = 'bg-danger';
                                                break;
                                                case 'billing':
                                                $departmentColor = 'bg-warning';
                                                break;
                                                }
                                                @endphp
                                                @php
                                                $statusColor = '';
                                                switch ($chat->status) {
                                                case 'open':
                                                $statusColor = 'bg-success';
                                                break;
                                                case 'in process':
                                                $statusColor = 'bg-primary';
                                                break;
                                                case 'closed':
                                                $statusColor = 'bg-danger';
                                                break;
                                                }
                                                @endphp
                                                <i
                                                    class="fa-solid fa-user text-dark rounded-circle me-3 p-2 {{ $departmentColor }} text-white"></i>
                                                <div>
                                                    <h6 class="mb-0">
                                                        {{ $chat->name }}

                                                        <span class="badge {{$statusColor}}">{{ $chat->status }}</span>

                                                    </h6>
                                                    <small>{{ $chat->category }}</small>
                                                </div>
                                            </div>
                                            <small>{{ $chat->created_at->format('h:i A') }}</small>
                                            <!-- Assuming created_at field in your Chat model -->
                                            <!-- Timestamp -->
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>

                            <!-- Repeat similar structure for other chat items -->

                            <!-- Add more chat items as needed -->
                        </ul>
                    </div>
                </div>

                <!-- Right Panel for Selected Chat -->
                <div class="col-md-8" id="chat-adminSide">
                    @if (session('alert'))
                    <div class="alert alert-danger">
                        {{ session('alert') }}
                    </div>
                    @endif
                    @if (request()->is('admin/*') && isset($uniqueChat) && !empty($uniqueChat))
                    @php
                    $departmentColor = '';
                    switch ($uniqueChat->department) {
                    case 'sales':
                    $departmentColor = 'bg-success';
                    break;
                    case 'support':
                    $departmentColor = 'bg-primary';
                    break;
                    case 'technical':
                    $departmentColor = 'bg-danger';
                    break;
                    case 'billing':
                    $departmentColor = 'bg-warning';
                    break;
                    }
                    @endphp
                    @php
                    $statusColor = '';
                    switch ($uniqueChat->status) {
                    case 'open':
                    $statusColor = 'bg-success';
                    break;
                    case 'in process':
                    $statusColor = 'bg-primary';
                    break;
                    case 'closed':
                    $statusColor = 'bg-danger';
                    break;
                    }
                    @endphp
                    <div class="card msg-box">
                        <div class="card-header .bg-light " style="z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between">

                                <div class="d-flex align-items-center">
                                    <i
                                        class="fa-solid fa-user text-dark rounded-circle me-3 p-2 {{$departmentColor}} text-white"></i>
                                    <div>
                                        <h6 class="mb-0">
                                            {{$uniqueChat->name}}
                                            <span class="badge {{$statusColor}}">{{$uniqueChat->status}}</span>
                                            <!-- Badge for status -->
                                        </h6>
                                        <small>{{$uniqueChat->name}}@gmail.com</small>
                                    </div>
                                </div>
                                <a type="button" class="btn-close" aria-label="Close"
                                    href="{{route('admin.chat')}}"></a>
                            </div>

                        </div>
                        <div class="card-body msg-box-body overlay" style="overflow-y: auto;" id="chatContainer">
                            <!-- Chat Messages -->
                            <div class="chat-messages" id="chatMessageId">


                                <!-- User's Message -->
                                <div class="message incoming">
                                    <i class="fa-solid fa-user text-dark"></i>
                                    <div class="message-content">
                                        {{$uniqueChat->message}}
                                        <div class="message-meta">
                                            <span class="message-time">{{ $chat->updated_at->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- User's Message -->
                                <!-- Admin's Message -->
                                @if ($uniqueChat->admin_reply != null)

                                <div class="message outgoing">
                                    <div class="message-content">
                                        {{$uniqueChat->admin_reply}}
                                        <div class="message-meta">
                                            <span class="message-time">{{ $chat->updated_at->format('h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- Add more messages as needed -->
                            </div>
                            <!-- Chat Input -->
                            @if($uniqueChat->status!="closed")
                            <form id="adminReplyForm">
                                @csrf
                                <input type="hidden" name="chatId" id="chatId" value="{{$uniqueChat->id}}">
                                <div class="input-group mb-2 pr-5" style="position: fixed; bottom: 0;">
                                    <textarea name="adminMsg" id="adminMSG" class="form-control" rows="1"></textarea>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit"> <i
                                                class="fa-solid fa-paper-plane fa-2x"></i></button>
                                    </div>
                                </div>
                            </form>
                            <script>
                                document.getElementById("adminReplyForm").addEventListener("submit", function(event) {
                                    event.preventDefault(); // Prevent default form submission
                                   var adminMsgTextarea = document.getElementById('adminMSG'); // Get adminMsg value
                                    var chatId = document.getElementById("chatId").value; // Get id value
                                   var adminMsg= adminMsgTextarea.value;
                        
                                    // Make AJAX request to send admin reply
                                    fetch("{{ route('admin.reply') }}", {
                                        method: "POST",
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({
                                            adminMsg: adminMsg,
                                            chatId: chatId,
                                         
                                        })
                                    })
                                    .then(response => {
                                       if (response.ok) {
                                    // Do something if successful
                                    // console.log("Admin reply sent successfully.");
                                    
                                    // Get the chat container
                                    var chatContainer = document.getElementById('chatMessageId');
                                    
            
                                    // Clear the textarea
                                    adminMsgTextarea.value = '';
                                    
                                    // Create the HTML structure for the admin message
                                    let chatMsg = `
                                    <div class="message outgoing">
                                        <div class="message-content">
                                            ${adminMsg}
                                            <div class="message-meta">
                                                <span class="message-time">{{ $chat->updated_at->format('h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>`;
                                    
                                    // Append the admin message to the chat container
                                    chatContainer.insertAdjacentHTML('beforeend', chatMsg);
                                    scrollChatToBottom();
                                    } else {
                                           alert("Failed to send admin reply.");
                                            // console.error("Failed to send admin reply.");
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                    });
                                });
                            </script>
                            @endif
                        </div>
                    </div>
                    @else
                    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                        <div>
                            <img src="{{ asset('asset/support.jpg') }}" alt="Support Team Image"
                                style="max-width: 100%; max-height: 70vh; width: auto; height: auto; display: block; margin: 0 auto;">
                            <p style="text-align: center; font-size: 18px; margin-top: 20px;">Your support is needed!
                                Don't keep your
                                customers waiting. Engage them now!</p>
                        </div>
                    </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
    <script>
        Echo.channel('MessageUpdate')
.listen('ChatEvent', (event) => {
console.log(event.message);
});
    </script>
    <script src="{{ asset('js/admin/script.js') }}"></script>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>