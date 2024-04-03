<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Web Application</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link href="{{ asset('css/client/style.css') }}" rel="stylesheet">
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
                session with one of our knowledgeable representatives and get real-time support tailored to your needs.
                Whether you're facing technical issues, have product inquiries, or need guidance, we're here to provide
                prompt and friendly assistance. Connect with us now and experience hassle-free support!</p>
        </div>
    </div>
</div>
    <button id="chatButton" class="btn btn-primary rounded-circle"><i class="fa-solid fa-comments fas"></i></button>

    <div id="chatBox">
        <div class="card">
            <div class="card-header chat-header">
                Chat Box
                <button id="maximizeChat" class="btn btn-sm btn-secondary float-right"><i
                        class="fas fa-compress-alt"></i></button>
            </div>
            <div class="card-body chat-content" id="userMgCon">
                <div id="chatMessages" class="container">
                    <form action="" id="convForm">
                        <p>Please select the department you wish to talk to.
                        </p>
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
                                    required>
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
                                <button class="btn btn-primary btn-block">Start Conversation</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="input-group p-3" id="userMessageInput" style="display: none;">
                <input type="text" class="form-control" placeholder="Type your message...">
                <button class="btn btn-primary sendbutton" type="button" id="sendMessageButton">Send
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <!-- <div class="card-footer">
                <input type="text" class="chat-input form-control" placeholder="Type your message...">
            </div> -->
        </div>
    </div>



   <script src="{{ asset('js/client/script.js') }}"></script>
</body>

</html>