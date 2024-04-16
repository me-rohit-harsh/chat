<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>
    <!-- Custome css  -->
    <link rel='stylesheet' href='style.css'>
</head>

<body>
    <div class="container my-3">
        <!-- Your HTML content here -->
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


        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (Session::has('error'))
                        <div class="alert alert-danger">
                            <strong>Oops!</strong> {{ Session::get('error') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">



            <div class="card mb-3">
                <div class="card-body">

                    <form action="{{route('ticket.list')}}" id="myForm">

                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Search By </label>
                                    <input type="text" placeholder="ID,Subject,Customer,Message & Status"
                                        class="select-single  form-control user_id" name="search" id="user_id">
                                </div>

                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Filter By Department</label>
                                    <select name="search" id="department" class="form-control">
                                        <option value="" selected disabled> Select department</option>
                                        <option value="Sales Team">Sales Team</option>
                                        <option value="General Query">General Query</option>
                                        <option value="Technical Support">Technical Support</option>
                                    </select>
                                </div>
                            </div>



                            <div class="col-sm-3">
                                <div class="form-group" style="margin-top: 2rem!important;">
                                    <button onclick="resetForm()" class="btn btn-dark">
                                        <i class="fas mr-2 fa-solid fa-rotate-right"></i>
                                        Reset
                                    </button>

                                    <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i>
                                        Search</button>

                                </div>

                            </div>


                        </div>



                    </form>


                </div>
            </div>






            <div class="card">

                <div class=" ">
                    <div class="">


                    </div>
                </div>

                <div class="card-header">
                    <h3 class="card-title">Ticket List</h3>
                </div>

                <div class="card-body">

                    <table id="example1" class="table table-bordered table-striped" data-toggle="table"
                        data-pagination="true" data-search="true">
                        <thead>
                            <tr>
                                {{-- <th>Action</th> --}}
                                <th>Department</th>
                                <th>Subject</th>
                                <th>Requestor</th>
                                {{-- <th>Image</th> --}}
                                <th>Status</th>
                                <th>Last Reply</th>


                            </tr>
                        </thead>
                        <tbody>

                            @foreach($tickets as $ticket)

                            <tr>
                                {{-- <td>

                                    <a href="" onclick="openModal(event, {{$ticket->id}})"><i
                                            class="fa fa-comment"></i></a>
                                    <a href="" onclick="openAdminReplyModal(event, {{$ticket->id}})"><i
                                            class="fa fa-reply"></i></a>

                                </td> --}}
                                <td>{{$ticket->department}}</td>
                                <td>
                                    <a href="/admin/ticket/{{$ticket->id}}">#{{$ticket->id}} -
                                        {{$ticket->category}}</a>

                                </td>


                                <td>
                                    {{$ticket->user->name}} <br>
                                    {{$ticket->user->email}}
                                </td>



                                {{-- <td style="width: 10%">
                                    @if($ticket->asset)
                                    <img width="100px" height="50px" src="{{ asset($ticket->asset->image_path) }}"
                                        class="img-fluid" alt="Ticket Image">
                                    @else
                                    <input type="text" class="form-control" readonly placeholder="No Image">
                                    @endif

                                </td> --}}




                                <td>


                                    <select class="form-control" name="status"
                                        onchange="saveTicketStatus(event, this.value, {{$ticket->id}})">


                                        <option value="" disabled>select status</option>

                                        {{-- @foreach(ticketSatus() as $key=> $CStatus)
                                        <option value="{{$CStatus}}" @if ($ticket->status== $CStatus) selected @endif >
                                            {{$CStatus}} </option>
                                        @endforeach --}}
                                        <option value="open">Open</option>
                                        <option value="in process">In process</option>
                                        <option value="closed">Closed</option>
                                    </select>
                                </td>


                                <td>
                                    {{($ticket->updated_at)}}

                                </td>

                            </tr>


                            @endforeach

                        </tbody>
                    </table>
                    <div class="row my-2">
                        <div class="col-sm-10">
                            {{ $tickets->links() }}



                        </div>

                        <div class="col-sm-2">

                            Total Records: {{$tickets->total() }}


                        </div>
                    </div>


                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add Comment</h4>
                                    <input type="hidden" id="ticketId">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="form-control" id="message" rows="3"></textarea>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger float-right"
                                        data-dismiss="modal">Close</button>
                                    <button type="button" id="saveComment" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>

                    </div>


                    <div class="modal fade" id="modal-default-reply">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Admin Reply</h4>
                                    <input type="hidden" id="ticketId-reply">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="form-control" id="message-reply" rows="3"></textarea>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger float-right"
                                        data-dismiss="modal">Close</button>
                                    <button type="button" id="save-reply" class="btn btn-primary">Save</button>
                                </div>
                            </div>

                        </div>

                    </div>








                </div>

            </div>
        </section>


        <script type="text/javascript">
            function openModal(e, ticketId){
            e.preventDefault();
            $('#modal-default').modal('show');
            $('#ticketId').val(ticketId);
        
          }
        
          function openAdminReplyModal(e, ticketId){
            e.preventDefault();
            $('#modal-default-reply').modal('show');
            $('#ticketId-reply').val(ticketId);
        
          }
        
          
          
          $('#save-reply').on('click',function(){
        
        
        var id=$('#ticketId-reply').val();
        var message=$('#message-reply').val();
          $.ajax({
                url: "{{route('save.reply')}}",
                type: "POST",
                data: {
                 id:id,
                 message:message,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
        
                 if(result){
                   $('#modal-default').modal('hide');
                   alert('Comment Saved Successfully');
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
        //                 alert('Comment Saved Successfully');
        //                 window.location.reload();
        
        //               }
                       
        //              }
        //          });
        
        //   });
        
        
        //   function saveTicketStatus(e,status,id){
        
        //     e.preventDefault();
          
        //     if(status){
        //       $('#loaders').show();
        //       $.ajax({
        //              url: "{{route('save.ticket.status')}}",
        //              type: "POST",
        //              data: {
        //               id:id,
        //               status:status,
        //                  _token: '{{csrf_token()}}'
        //              },
        //              dataType: 'json',
        //              success: function (result) {
        
        //               if(result){
        //                 showMessage(result.msg,result.category,'alert-info');
                           
        //                 $('#loaders').hide();
        
        //               }
                       
        //              }
        //          });
        
        
        //     }else{
        
        //       alert("please select valid status");
        //       window.location.reload();
        
        //     }
              
        
        
        
        
        //   }
               
        
          function resetForm() {
            document.getElementById("myForm").reset();
            history.pushState({}, document.title, window.location.pathname);
          }
        
        </script>
        <!-- Bootstrap JS (optional) -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
    </div>
</body>

</html>