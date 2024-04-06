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
            <form action="">
                <div class="input-group p-3" id="userMessageInput" style="display: none;">
                    <input type="text" class="form-control" placeholder="Type your message...">
                    <button class="btn btn-primary sendbutton" type="button" id="sendMessageButton">Send
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
            <!-- <div class="card-footer">
                <input type="text" class="chat-input form-control" placeholder="Type your message...">
            </div> -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
        $('#convForm').submit(function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get form data
            var formData = $(this).serialize();

            // Send AJAX request
            $.ajax({
                url: '/start-conv', // Assuming this is the route to your startConv function
                type: 'POST',
                data: formData,
                success: function(response) {
                    sendMessage();
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
        Echo.channel('MessageUpdate')
.listen('ChatEvent', (event) => {
console.log(event.message);
});
    </script>
    <script src="{{ asset('js/client/script.js') }}"></script>
</body>

</html>