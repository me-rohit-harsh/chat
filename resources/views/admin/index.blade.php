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
                                <input type="text" class="form-control" placeholder="Search users..." id="searchInput">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterBtn"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="filterBtn">
                                    <li><a class="dropdown-item" href="#" data-status="all">All</a></li>
                                    <li><a class="dropdown-item  text-warning" href="#" data-status="Open">Open</a></li>
                                    <li><a class="dropdown-item  text-primary" href="#" data-status="In process">In
                                            process</a></li>
                                    <li><a class="dropdown-item text-danger" href="#" data-status="Closed">Closed</a>
                                    </li>
                                    <!-- Add more status options as needed -->
                                </ul>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush live-chats " id="chatList">
                            <!-- Chat Item 1 -->
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-success text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                John Doe
                                                <span class="badge bg-primary">In process</span>
                                                <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 1</small>
                                        </div>
                                    </div>
                                    <small>10:30 AM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-success text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                John Doe
                                                <span class="badge bg-primary">In process</span>
                                                <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 1</small>
                                        </div>
                                    </div>
                                    <small>10:30 AM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-success text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                John Doe
                                                <span class="badge bg-primary">In process</span>
                                                <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 1</small>
                                        </div>
                                    </div>
                                    <small>10:30 AM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-success text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                John Doe
                                                <span class="badge bg-primary">In process</span>
                                                <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 1</small>
                                        </div>
                                    </div>
                                    <small>10:30 AM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-primary text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                Jane Smith
                                                <span class="badge bg-primary">In process</span>
                                                <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 2</small>
                                        </div>
                                    </div>
                                    <small>11:45 AM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-danger text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                Alice Johnson
                                                <span class="badge bg-warning">Open</span> <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 3</small>
                                        </div>
                                    </div>
                                    <small>12:15 PM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-warning text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                Michael Brown
                                                <span class="badge bg-danger">Closed</span> <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 4</small>
                                        </div>
                                    </div>
                                    <small>1:30 PM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-info text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                David Wilson
                                                <span class="badge bg-danger">Closed</span> <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 5</small>
                                        </div>
                                    </div>
                                    <small>2:45 PM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-primary text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                Jane Smith
                                                <span class="badge bg-primary">In process</span>
                                                <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 2</small>
                                        </div>
                                    </div>
                                    <small>11:45 AM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-danger text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                Alice Johnson
                                                <span class="badge bg-warning">Open</span> <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 3</small>
                                        </div>
                                    </div>
                                    <small>12:15 PM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-warning text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                Michael Brown
                                                <span class="badge bg-danger">Closed</span> <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 4</small>
                                        </div>
                                    </div>
                                    <small>1:30 PM</small> <!-- Timestamp -->
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i
                                            class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-info text-white"></i>
                                        <div>
                                            <h6 class="mb-0">
                                                David Wilson
                                                <span class="badge bg-danger">Closed</span> <!-- Badge for status -->
                                            </h6>
                                            <small>Subject of Message 5</small>
                                        </div>
                                    </div>
                                    <small>2:45 PM</small> <!-- Timestamp -->
                                </div>
                            </li>

                            <!-- Repeat similar structure for other chat items -->

                            <!-- Add more chat items as needed -->
                        </ul>
                    </div>
                </div>

                <!-- Right Panel for Selected Chat -->
                <div class="col-md-8" id="chat-adminSide">
                    <div class="card msg-box">
                        <div class="card-header bg-secondary text-white" style="z-index: 10;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <i
                                        class="fa-solid fa-user text-dark rounded-circle me-3 p-2 bg-info text-white"></i>
                                    <div>
                                        <h6 class="mb-0">
                                            David Wilson
                                            <span class="badge bg-danger">Closed</span> <!-- Badge for status -->
                                        </h6>
                                        <small>example@gmail.com</small>
                                    </div>
                                </div>
                                <a type="button" class="btn-close" aria-label="Close"></a>
                            </div>

                        </div>
                        <div class="card-body msg-box-body overlay" style="overflow-y: auto;" id="chatContainer">
                            <!-- Chat Messages -->
                            <div class="chat-messages">
                                <!-- Admin's Message -->
                                <div class="message outgoing">
                                    <div class="message-content">
                                        Sample message 1 Sample message 1 this is the mew m,sgaaaaaa
                                        Sample message 1
                                        Sample message 1
                                        Sample message 1

                                        <div class="message-meta">
                                            <span class="message-time">10:00 AM</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- User's Message -->
                                <div class="message incoming">
                                    <i class="fa-solid fa-user text-dark"></i>
                                    <div class="message-content">
                                        Sample message content
                                        <div class="message-meta">
                                            <span class="message-time">10:30 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- User's Message -->
                                <div class="message incoming">
                                    <i class="fa-solid fa-user text-dark"></i>
                                    <div class="message-content">
                                        Sample message content
                                        <div class="message-meta">
                                            <span class="message-time">10:30 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- User's Message -->

                                <div class="message outgoing">
                                    <div class="message-content">
                                        Sample message 1
                                        <div class="message-meta">
                                            <span class="message-time">10:00 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="message outgoing">
                                    <div class="message-content">
                                        Sample message 1
                                        <div class="message-meta">
                                            <span class="message-time">10:00 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="message outgoing">
                                    <div class="message-content">
                                        Sample message 1
                                        <div class="message-meta">
                                            <span class="message-time">10:00 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="message incoming">
                                    <i class="fa-solid fa-user text-dark"></i>
                                    <div class="message-content">
                                        Sample message contentSample message contentSample message contentSample message
                                        contentSample message contentSample message contentSample message content
                                        <div class="message-meta">
                                            <span class="message-time">10:30 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add more messages as needed -->
                            </div>
                            <!-- Chat Input -->
                            <div class="input-group mt-3" style="position: sticky; bottom: 0;">
                                <textarea name="adminMsg" id="adminMSG" class="form-control" rows="2"></textarea>
                                <!-- <textarea class="form-control" placeholder="Type your message..."></textarea> -->
                                <button class="btn btn-success">Send message <i
                                        class="fa-solid fa-paper-plane fa-2x"></i></button>
                            </div>

                        </div>

                    </div>

                </div>


            </div>
        </div>
    </div>

   <script src="{{ asset('js/admin/script.js') }}"></script>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>