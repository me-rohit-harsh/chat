<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>View Ticket :: Oxyclouds</title>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>
     <!-- Custome css  -->
    <link rel='stylesheet' href='style.css'>
</head>
<body>

  <style>
    .ticket-nav:hover,
    .ticket-nav {
        background-color: #2E004B !important;
        background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0) 100%) !important;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3) !important;
        color: #d6e4ff !important;
        font-size: 21px !important;

    }
</style>

{{-- cdns for image popup --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
{{-- ticket css starts --}}
<style>
    /* Custom CSS for adjusting specific elements */
    .card {
        margin-bottom: 20px;
        /* Add some spacing between cards */
    }


    .userChat {
        background-color: #F7FAFD;
    }

    .supportChat {
        background-color: #FAF8F1;
    }

    #ticketreply a {
        text-decoration: none;
    }

    .requestor-type-owner,
    .requestor-type-operator {
        font-size: smaller;
        background-color: #5BC0DE;
        padding: 5px 5px;
        border-radius: 5px;
        color: #fff
    }

    .requestor-type-owner {
        background-color: #12d671;
    }

    #editor-container {
        height: 250px;
    }

    #counter {
        border: 1px solid #ccc;
        border-width: 0px 1px 1px 1px;
        color: #aaa;
        padding: 5px 15px;
        text-align: right;
    }

    .tab {
        margin-bottom: 0;
        padding: 5px;
        border: #000 solid 1px;
        display: inline-block;
        border-radius: 10px 10px 0 0;
        cursor: pointer;
        border-bottom: none;
    }

    .attach-files-container,
    .bottomPart {
        background-color: #F7FAFD;
        padding: 10px;
        border-bottom-right-radius: 10px;
        border-bottom-left-radius: 10px;
        justify-content: space-between
    }

    .fa-comment {
        cursor: pointer;
        color: rgb(37, 25, 107);
    }

    .devider {
        border-right: 1px solid #565050;
        text-align: right;
    }

    .upper-ticket {
        justify-content: space-between
    }

    hr {
        border-bottom: #000 1px solid;
    }
</style>
<div class="row mx-2">

    <div class="col-sm-12  mt-2">
        <!-- Success and Error Messages -->
        <div id="messages" class="mt-3">
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif


            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <div id="ticketClosedMessage" style="display: none;" class="alert alert-success">Ticket closed successfully
            </div>
        </div>
        <!-- End of Success and Error Messages -->
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="d-inline">TICKET DETAILS(<span style="font-weight: 100">{{ $ticket->status }}</span>)</h3>
            @if($ticket->status!="Closed")
            <button onclick="if(confirm('Are you sure to close the ticket?')) { closeTicket(event, {{$ticket->id}}); }"
                class="btn btn-danger">Close Ticket</button>
            @endif
        </div>

        <div class="upper-ticket">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1">
                    <h5> <a href="{{ $ticket->id }}">#{{ $ticket->id }}</a> - {{ $ticket->category }}</h5>
                </div>
                <div>
                    @php
                    $currentTime = now();
                    $lastReplyTime = $ticket->updated_at;
                    $timeDifference = $currentTime->diff($lastReplyTime);
                    @endphp

                    <p class="badge bg-primary mx-2">
                        Last Reply:
                        {{ $timeDifference->h }} Hours
                        {{ $timeDifference->i }} Minutes
                        {{ $timeDifference->s }} Seconds Ago
                    </p>
                </div>
            </div>
        </div>
        {{-- CSS For Message Box--}}
        <style>
            .text-editor {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }


            .text-editor.tab {
                /* Add styling for the button */
                padding: 8px 16px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-bottom: 10px;
                margin-bottom: 10px;
            }


            #text-editor textarea {


                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                resize: vertical;
            }
        </style>
        {{-- Message Box --}}
        @if($ticket->status!='Closed')
        <form method="post" action="{{route('ticket.cus.con')}}" enctype="multipart/form-data">
            @csrf
            <div id="text-editor" class="text-editor">
                <label for="replyTextArea" class="tab shadow commentIcon">Add Reply</label>
                <textarea required id="replyTextArea" name="message" cols="30" rows="10"
                    placeholder="Write Your Message here........."></textarea>
            </div>
            <input type="hidden" name="ticketId" value="{{ $ticket->id }}">
            <div class="bottomPart d-flex ">
                <button class="btn border my-2 mr-2 attach-files-btn" type="button">
                    <i class="fas mr-2 fa-regular fa-file"></i> Attach Files
                </button>
                <button class="btn btn-primary my-2" type="submit">
                    <i class="fas mr-2 fa-solid fa-share"></i> Send Reply
                </button>
            </div>
            <div class="attach-files-container mt-3 px-2" style="display: none;">
                Max file size: 50MB
                <div class="input-group">
                    <input type="file" name="file[]" class="form-control" aria-label="File input">
                    <button class="btn btn-secondary add-more-btn" type="button"><i class="fas fa-solid fa-plus"></i>
                        Add
                        More</button>

                </div>

            </div>
        </form>
        @endif
       
        @foreach ($sortedConversations as $conversation)
        <div class="">
            <div class="row">
                <div class="col-md-12">
                    @if ($conversation->con_type === "Admin")
                    <div class="container shadow card p-3 my-2 userChat">
                        <div class="row ">

                            <div class="col-3 devider">
                                <div class="leftcol text-right">
                                    <div class="submitter my-2">
                                        <div class="name">
                                            <div class="requestor-name">
                                                Admin
                                            </div>
                                            <span class="label requestor-type-operator">
                                                Operator
                                            </span>
                                        </div>
                                        <div class="title">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-9">
                                <div class="rightcol">
                                    <div class="postedon d-flex mb-2" style="justify-content: space-between ">
                                        <span class="badge bg-info text-dark" style="color: #000 ">Posted on {{
                                            $conversation->created_at->isoFormat('dddd Do MMMM
                                            [at] HH:mm') }}</span>
                                        <div class=" p-1"><i class="fas fa-solid fa-comment commentIcon"></i></div>
                                    </div>
                                    <div class="msgwrap" id="contentr35459">
                                        <div class="">
                                            <p> {{$conversation->message}}</p>

                                            <!-- Display attachment if available -->
                                            @if($conversation->asset_id)
                                            <div>
                                                <p class="mb-1">Attachment(s):</p>
                                                @php
                                                $assetPaths = getAssetPathList($conversation->asset_id);
                                                $assetCount = count($assetPaths);
                                                @endphp
                                                @foreach($assetPaths as $index => $imgpath)
                                                <a target="_blank" href="{{ asset($imgpath) }}" class="image-link1">
                                                    View Image {{ $index + 1 }} of {{ $assetCount }}
                                                </a>
                                                @if(!$loop->last)
                                                <br>
                                                @endif
                                                @endforeach
                                            </div>
                                            @endif
                                            <script>
                                                $(document).ready(function() {
                                            $('.image-link1').magnificPopup({type:'image'});
                                        });
                                            </script>
                                            <hr>

                                            <p>
                                                Warm regards, <br>
                                                The Team at Rise Domain
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    @else
                    <div class="container card shadow p-3 my-2 supportChat">
                        <div class="row ">
                            <div class="col-3 devider">
                                <div class="leftcol text-right">
                                    <div class="submitter my-2">
                                        <div class="name">
                                            <div class="requestor-name">
                                                <a href="clientssummary.php?userid=3327">
                                                    {{$customer->firstname}} {{$customer->lastname}}
                                                </a>
                                            </div>
                                            <span class="label requestor-type-owner">
                                                Owner
                                            </span>
                                        </div>
                                        <div class="title">
                                            <a href="mailto:{{$customer->email}}">{{$customer->email}}</a>
                                            <br>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-9">
                                <div class="rightcol">
                                    <div class="postedon d-flex mb-2" style="justify-content: space-between ">
                                        <span class="badge bg-info text-dark" style="color: #000 ">Posted on {{
                                            $conversation->created_at->isoFormat('dddd Do MMMM [at] HH:mm') }}</span>
                                        <div class=" p-1"><i class="fas fa-solid fa-comment commentIcon"></i></div>
                                    </div>

                                    <div class="msgwrap" id="contentt19953">
                                        <div class="">
                                            <p>{{$conversation->message}}</p>

                                            <!-- Display attachment if available -->
                                            @if($conversation->asset_id)
                                            <div>
                                                <p class="mb-1">Attachment(s):</p>
                                                @php
                                                $assetPaths = getAssetPathList($conversation->asset_id);
                                                $assetCount = count($assetPaths);
                                                @endphp
                                                @foreach($assetPaths as $index => $imgpath)
                                                <a target="_blank" href="{{ asset($imgpath) }}" class="image-link1">
                                                    View Image {{ $index + 1 }} of {{ $assetCount }}
                                                </a>
                                                @if(!$loop->last)
                                                <br>
                                                @endif
                                                @endforeach
                                            </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <!-- Moved IP address here -->
                                    <p class="mb-0 px-3">IP Address: {{$customer->ip_address}}</p>
                                </div>
                            </div>




                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
        {{-- Message Box Ends--}}
<div class="container card shadow p-3 my-2 supportChat">
    <div class="row ">
        <div class="col-3 devider">
            <div class="leftcol text-right">
                <div class="submitter my-2">
                    <div class="name">
                        <div class="requestor-name">
                            <a href="clientssummary.php?userid=3327">
                                {{$customer->firstname}} {{$customer->lastname}}
                            </a>
                        </div>
                        <span class="label requestor-type-owner">
                            Owner
                        </span>
                    </div>
                    <div class="title">
                        <a href="mailto:{{$customer->email}}">{{$customer->email}}</a>
                        <br>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-9">
            <div class="rightcol">
                <div class="postedon d-flex mb-2" style="justify-content: space-between ">
                    <span class="badge bg-info text-dark" style="color: #000 ">Posted on {{
                        $ticket->created_at->isoFormat('dddd Do MMMM [at] HH:mm') }}</span>
                    <div class=" p-1"><i class="fas fa-solid fa-comment commentIcon"></i></div>
                </div>

                <div class="msgwrap" id="contentt19953">
                    <div class="">
                        <p>{{$ticket->message}}</p>

                        <!-- Display attachment if available -->
                        @if($ticket->asset_id)
                        <div>
                            <p class="mb-1">Attachment(s):</p>
                            @php
                            $assetPaths = getAssetPathList($conversation->asset_id);
                            $assetCount = count($assetPaths);
                            @endphp
                            @foreach($assetPaths as $index => $imgpath)
                            <a target="_blank" href="{{ asset($imgpath) }}" class="image-link1">
                                View Image {{ $index + 1 }} of {{ $assetCount }}
                            </a>
                            @if(!$loop->last)
                            <br>
                            @endif
                            @endforeach
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="row">
                <hr>
                <!-- Moved IP address here -->
                <p class="mb-0 px-3">IP Address: {{$customer->ip_address}}</p>
            </div>
        </div>




    </div>
</div>
    </div>
</div>


<!-- script to attatch file starts -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
            const attachFilesBtn = document.querySelector('.attach-files-btn');
            const attachFilesContainer = document.querySelector('.attach-files-container');
            const addMoreBtn = document.querySelector('.add-more-btn');

            attachFilesBtn.addEventListener('click', function () {
                attachFilesContainer.style.display = (attachFilesContainer.style.display === 'none') ? 'block' : 'none';
            });

            let fileInputCount = 1;
            addMoreBtn.addEventListener('click', function () {
                if (fileInputCount < 5) {
                    const newFileInput = document.createElement('input');
                    newFileInput.type = 'file';
                    newFileInput.name = 'file[]';
                    newFileInput.className = 'form-control mt-2';
                    newFileInput.setAttribute('aria-label', 'File input');
                    attachFilesContainer.appendChild(newFileInput);
                    fileInputCount++;
                } else {
                    addMoreBtn.disabled = true;
                }
            });
        });
        // Focus on replyTextArea by clicking on add reply
        // Focus on replyTextArea by clicking on add reply
        document.addEventListener('DOMContentLoaded', function() {
    var replyLabel = document.querySelector('.tab');
    var commentIcons = document.querySelectorAll('.commentIcon');

    commentIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            replyTextArea.focus();
        });
    });
});

</script>
<script>
    function closeTicket(event, ticketId) {
        event.preventDefault();
      

        // Send an AJAX request to mark the ticket as closed
        $.ajax({
            
            type: "POST",
            url: "{{route('close.ticket')}}",
            data: {
                _token: "{{ csrf_token() }}",
                id: ticketId
            },
            success: function(response) {
                $('#ticketClosedMessage').show();
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    }
</script>

    <!-- Bootstrap JS (optional) -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>