<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Web Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/client/style.css') }}" rel="stylesheet">
    <script src="{{asset('js/app.js')}}"></script>
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="https://img.freepik.com/free-vector/flat-design-whatsapp-chat-template_23-2151240184.jpg"
                    class="img-fluid" alt="WhatsApp Image">
            </div>
            <div class="col-md-6">
                <h2>Welcome to Our Client Support Chat</h2>
                <p class="lead">Need assistance or have a question? Our support team is here to help! Start a live chat
                    session with one of our knowledgeable representatives and get real-time support tailored to your
                    needs.
                    Whether you're facing technical issues, have product inquiries, or need guidance, we're here to
                    provide
                    prompt and friendly assistance. Connect with us now and experience hassle-free support!</p>
                <a href="{{route('user.chat.list')}}"> <i class="fas fa-solid fa-list"></i> Show All Chats</a>
            </div>
        </div>
    </div>
    <button id="chatButton" class="btn btn-primary rounded-circle"><i class="fa-solid fa-comments fas"></i></button>

    <div id="chatBox">
        <div class="card">
            <div class="card-header chat-header">
                Oxyclouds Live Chat
                <button id="maximizeChat" class="btn btn-sm btn-secondary float-right"><i
                        class="fas fa-compress-alt"></i></button>
            </div>
            <div class="card-body chat-content" id="userMgCon">
                <div id="chatMessages" class="container">
                    <form id="convForm">
                        @csrf
                        <p>Please select the department you wish to talk to.
                        </p>
                        {{-- <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" placeholder="Enter full name" required
                                    name="name">
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label for="department" class="col-sm-4 col-form-label">Department</label>
                            <div class="col-12">
                                <select name="department" id="department" class="form-control">
                                    <option value="sales">Sales</option>
                                    <option value="support">Support</option>
                                    <option value="technical">Technical</option>
                                    <option value="billing">Billing</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-sm-4 col-form-label">Subject</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="subject" placeholder="Enter Subject"
                                    required name="category">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="message" class="col-sm-4 col-form-label">Message</label>
                            <div class="col-sm-12">
                                <textarea name="message" class="form-control" id="message" rows="4"
                                    placeholder="Enter your message" required></textarea>

                            </div>
                        </div>
                        <div class="form-group row" style="margin-bottom: 1rem;">
                            <div class="col-sm-12">
                                <button class="btn btn-primary btn-block" type="submit">Start Conversation</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <form action="" id="chatForm">
                @csrf
                <div class="input-group p-3" id="userMessageInput" style="display: none;">
                    <input type="text" name="chatMsg" id="chat_msg" class="form-control"
                        placeholder="Type your message...">
                    <button class="btn btn-primary sendbutton" type="button" id="sendMessageButton">Send
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#convForm').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();
var message = $('#message').val();
            // Get form data
            var formData = $(this).serialize();
// console.log(formData);
            // Send AJAX request
            $.ajax({
                url: '/start-conv', // Assuming this is the route to your startConv function
                type: 'POST',
                data: formData,
                success: function(response) {
                    var hiddenInput = $('<input>').attr({
                    type: 'hidden',
                    name: 'chatId',
                    value: response.chatId,
                    id:'chat_id'
                    });  
                    // Diplaying the msg in the text tab as soon as the conversation started 
                    // Previously i was utilize the Event to do so as done below
                    sendMessage(message);
                    // Append the hidden input to your form or any other desired location
                    $('form').append(hiddenInput);
                    // Handle successful response
                    // alert('Conversation started successfully');
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    var errorMessage = xhr.responseText; // Get the error message from the response
                    alert('Error: ' + errorMessage); // Display the error message to the user
                }
            });
        });    
    });
    </script>
    <script>
        $(document).ready(function() {
        // Click event handler for the send button
        $('#sendMessageButton').click(function(event) {
            // Prevent default form submission
            event.preventDefault();
            // Get form data
            var message = $('#chat_msg').val();
            var requestData = {
            'message': message, 
            };
            // Send AJAX request
            $.ajax({
                url: '{{ url("update-chat-message") }}/' + $('#chat_id').val(), 
                type: 'POST',
                data: requestData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token
                },
                success: function() {
                    // Handle success response
                    addConversation(message);
                    // console.log("Chat updated success");
                    // If needed, append the updated message or perform other actions
                },
                error: function(xhr) {
                    // Handle error response
                    console.error('Failed to update chat message:', xhr.responseText);
                }
            });
        });
    });
    </script>
    <script>
        // To display admin MSG 
        Echo.channel('MessageUpdate').listen('ChatEvent', (data) => {
            if ({{ auth()->id() }} === data.chat.user_id) {
                // Set the message content
                let incomingMsg = `<div class="message incoming">
                    <div class="message-content">${data.chat.admin_reply}</div>
                </div>`;
                // Append the message element to the chatMessages element
                document.getElementById('chatMessages').innerHTML += incomingMsg;
                scrollChatToBottom();
            }
        });
        // To display the user msg in the next tab 
        // Echo.channel('UserChat').listen('UserChatEvent', (data) => {
        //     if ({{ auth()->id() }} === data.chat.user_id) {
        //         sendMessage(data.chat.message);
        //     }
        // });
        // To display the next msg of user 

    </script>
    <script src="{{ asset('js/client/script.js') }}"></script>
</body>

</html>