<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Ticket</title>
    {{-- JQuery script --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>
    <!-- Custome css  -->
    <link rel='stylesheet' href='style.css'>
</head>

<body>

    <!-- Your HTML content here -->
    <div class="container card shadow mt-3">
        <style>
            .select2-container .select2-selection--single {
                box-sizing: border-box;
                cursor: pointer;
                display: block;
                height: 39px !important;
                user-select: none;
                -webkit-user-select: none;
            }
        </style>
        {{-- cdns for image popup --}}
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js">
        </script>
        {{-- chat css starts --}}

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
                padding: 0 5px;
                border-radius: 5px;

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
                /* min-height:150px; */
            }

            .upper-ticket {
                justify-content: space-between
            }

            .statusBar {
                width: 130px !important
            }

            .tools {
                bottom: 0.5rem;
                right: 0.5rem;
                position: absolute;
            }
        </style>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-8">
                        <h2><strong>TICKET DETAILS</strong>({{$ticket->department}}) </h2>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">

            <div class="upper-ticket">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1">
                        <h5><a href="{{ $ticket->id }}">#{{ $ticket->id }}</a> - {{ $ticket->category }}
                            <select class="form-control statusBar d-inline" name="status"
                                onchange="saveTicketStatus(event, this.value, {{$ticket->id}})">
                                <option value="">select status</option>
                                <option value="open">Open</option>
                                <option value="in process">In process</option>
                                <option value="closed">Closed</option>
                                {{-- @foreach(ticketSatus() as $key=> $CStatus)
                                <option value="{{$CStatus}}" @if ($ticket->status== $CStatus) selected @endif>
                                    {{$CStatus}}
                                </option>
                                @endforeach --}}

                            </select>
                            {{-- <button type="button" value="Reply"
                                onclick="openAdminReplyModal(event, {{$ticket->id}},'create')" class="btn  btn-dark"> <i
                                    class="fas fa-solid fa-reply-all"></i> Reply</button> --}}
                        </h5>
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
            <form method="post" action="{{route('ticket.conversation')}}" enctype="multipart/form-data">
                @csrf
                <div id="text-editor" class="text-editor">
                    <label for="replyTextArea" class="tab shadow commentIcon">Add Reply</label>
                    <textarea required id="replyTextArea" name="message" cols="30" rows="10"
                        placeholder="Write Your Message here........."></textarea>
                </div>
                <input type="hidden" name="ticketId" value="{{$id}}">

                <div class="bottomPart d-flex ">
                    <button class="btn border my-2 mr-2 attach-files-btn" type="button">
                        <i class="fas mr-2 fa-regular fa-file"></i> Attach Files
                    </button>
                    <button class="btn btn-primary my-2" type="submit">
                        Send Reply <i class="fas fa-solid fa-reply-all"></i>
                    </button>
                </div>
                <div class="attach-files-container mt-3 px-2" style="display: none;">
                    Max file size: 50MB
                    <div class="input-group">
                        <input type="file" name="file[]" class="form-control" aria-label="File input">
                        <button class="btn btn-secondary add-more-btn" type="button"><i
                                class="fas fa-solid fa-plus"></i> Add
                            More</button>

                    </div>

                </div>
            </form>
            @endif

            {{-- Message Box Ends--}}
            <section id="ticketreply">



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
                                            <div class="tools">
                                                <div class="editbtnsr35459">

                                                    <input type="button" value="Edit"
                                                        onclick="openAdminReplyModal(event, {{$conversation->id}},'update','{{$conversation->message}}')"
                                                        class="btn btn-xs btn-small btn-dark mb-1">

                                                    <form action="{{ route('ticket.delete', $conversation->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-xs btn-small btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this ticket?');">Delete</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="rightcol">
                                            <div class="postedon d-flex mb-2" style="justify-content: space-between ">
                                                <span class="badge bg-light text-dark" style="color: #000 ">Posted on {{
                                                    $conversation->created_at->isoFormat('dddd Do MMMM
                                                    [at] HH:mm') }}</span>
                                                <div class=" p-1"><i class="fas fa-solid fa-comment commentIcon"></i>
                                                </div>
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
                                                        <a target="_blank" href="{{ asset($imgpath) }}"
                                                            class="image-link1">
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
                                                            {{$customer->name}}
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
                                            {{-- <div class="tools">
                                                <div class="editbtnst19953">
                                                    <input type="button" value="Edit" href=""
                                                        onclick="openModal(event, {{$conversation->id}},'{{$conversation->message}}')"
                                                        class="btn btn-xs btn-small btn-dark ">
                                                    <form action="{{ route('ticket.delete', $conversation->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-xs btn-small btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this ticket?');">Delete</button>
                                                    </form>

                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="rightcol">
                                            <div class="postedon d-flex mb-2" style="justify-content: space-between ">
                                                <span class="badge bg-light text-dark" style="color: #000 ">Posted on {{
                                                    $conversation->created_at->isoFormat('dddd Do MMMM [at] HH:mm')
                                                    }}</span>
                                                <div class=" p-1"><i class="fas fa-solid fa-comment commentIcon"></i>
                                                </div>
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
                                                        <a target="_blank" href="{{ asset($imgpath) }}"
                                                            class="image-link1">
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

                                        <div class=" text-right">
                                            <p class="text-right px-1 mb-0">IP Address: {{$customer->ip_address}}</p>
                                        </div>

                                    </div>




                                </div>

                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Customer Message</h4>
                                <input type="hidden" id="conversation_id">
                                <input type="hidden" id="cType">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea required class="form-control" id="message" rows="3"></textarea>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger float-right"
                                    data-dismiss="modal">Close</button>
                                <button type="button" id="savecustomercon" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </div>

                </div>


                <div class="modal fade" id="modal-default-reply">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit Admin Reply</h4>
                                <input type="hidden" id="ticketId-reply">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea required class="form-control" id="message-reply" rows="3"></textarea>
                            </div>
                            <input type="hidden" id="conversationType">
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger float-right"
                                    data-dismiss="modal">Close</button>
                                <button type="button" id="save-reply" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </div>

                </div>
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
            </section>



        </section>

        <script type="text/javascript">
            //     function openModal(e, cid,message){
    //     e.preventDefault();
    //     $('#modal-default').modal('show');
    //     $('#conversation_id').val(cid);
    //     $('#message').val(message);
    //   }
    
    
    
      function openAdminReplyModal(e, ticketId, type, message) {
        e.preventDefault();
        $('#modal-default-reply').modal('show');
        $('#ticketId-reply').val(ticketId);
        $('#conversationType').val(type);
        $('#message-reply').val(message); // Set the message in the textarea
    }
    
    
    
        $('#save-reply').on('click',function(){
        var id=$('#ticketId-reply').val();
        var message=$('#message-reply').val();
        var ctype=$('#conversationType').val();
      $.ajax({
            url: "{{route('ticket.admin.con')}}",
            type: "POST",
            data: {
             id:id,
             ctype:ctype,
             message:message,
                _token: '{{csrf_token()}}'
            },
            dataType: 'json',
            success: function (result) {
    
             if(result){
               $('#modal-default').modal('hide');
               alert('Ticket Replied Successfully');
    
               window.location.reload();
    
             }
    
            }
        });
    
    });
    
    
    
    
    //   $('#saveComment').on('click',function(){
    
    
    
    //      var id=$('#ticketId').val();
    //      var message=$('#message').val();
    //        $.ajax({
    //              url: "{{route('save.commet')}}",
    //              type: "POST",
    //              data: {
    //               id:id,
    //               message:message,
    //                  _token: '{{csrf_token()}}'
    //              },
    //              dataType: 'json',
    //              success: function (result) {
    
    //               if(result){
    //                 $('#modal-default').modal('hide');
    //                 alert('Client Message Edited Successfully');
    //                 window.location.reload();
    
    //               }
    
    //              }
    //          });
    
    //   });
    
    
    //     $('#savecustomercon').on('click',function(){
    
    
    
    //         var id=$('#conversation_id').val();
    //         var message=$('#message').val();
    
    //         $.ajax({
    //             url: "{{route('ticket.customer.con')}}",
    //             type: "POST",
    //             data: {
    //                 id:id,
    //                 message:message,
    //                 _token: '{{csrf_token()}}'
    //             },
    //             dataType: 'json',
    //             success: function (result) {
    
    //                 if(result){
    //                     $('#modal-default').modal('hide');
    //                    alert('Client Message Edited Successfully');
    //                     window.location.reload();
    
    //                 }
    
    //             }
    //         });
    
    //     });
    
    
    
      function saveTicketStatus(e,status,id){
    
        e.preventDefault();
        if(status){
       
          $.ajax({
                 url: "{{route('save.ticket.status')}}",
                 type: "POST",
                 data: {
                  id:id,
                  status:status,
                     _token: '{{csrf_token()}}'
                 },
                 dataType: 'json',
                 success: function (result) {
    
                //   if(result){
                //     showMessage(result.msg,result.category,'alert-info');
                //   }
    
                 }
             });
    
    
        }else{
    
          alert("please select valid status");
          window.location.reload();
    
        }
    
    
    
    
    
      }
    
    
      function resetForm() {
        document.getElementById("myForm").reset();
        history.pushState({}, document.title, window.location.pathname);
      }
    
        </script>
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
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>