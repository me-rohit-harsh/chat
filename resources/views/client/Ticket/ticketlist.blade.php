<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>Ticket List :: Live Chat Web Application</title>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>
     <!-- Custome css  -->
    <link rel='stylesheet' href='style.css'>
</head>
<body>

    <!-- Your HTML content here -->
<style>
    .vertical-tabs {

        height: 700px;
        padding-left: 0;
    }

    .mt-4,
    .my-4 {
        margin-top: 2rem !important;
    }
</style>

<div class="app-main ">

    <div class=" mt-2  mx-3 mb-3">
        <div class="row">

            <div class="col-sm-12">

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('warning'))
                <div class="alert alert-danger">
                    {{ session('warning') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <div class=""> <a href="{{route('user.raiseTicket')}}"
                        class="btn btn-primary "><i class=" mx-2 fa-solid fa-ticket"></i>Raise
                        New Ticket</a></div>
                <div class="modal fade" id="raiseTicketModal" tabindex="-1" role="dialog"
                    aria-labelledby="raiseTicketModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg modal-fullscreen"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title " id="raiseTicketModalLabel">Raise Ticket <button type="button"
                                        class="close" data-dismiss="modal" aria-label="Close"
                                        style="top: 20px; font-size: 30px;">
                                        <span aria-hidden="true">&times;</span>
                                    </button></h5>

                            </div>
                            <div class="modal-body">


                                @if ($errors->any())
                                <div>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <form method="post" action="{{route('add.tickets')}}" enctype="multipart/form-data">

                                    @csrf

                                    <div class="row justify-content-center">
                                        <div class="col-12">

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Subject </label>
                                                <input type="text" required class="form-control" name="category"
                                                    value="" placeholder="Enter Subject here...">
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5 ">
                                                    <label for="department">Department</label>
                                                    <select class="form-control" id="department" name="department">
                                                        <option value="General Query">General Query</option>
                                                        <option value="Technical Support">Technical Support
                                                        </option>
                                                        <option value="Sales Team">Sales Team</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-1 "></div>
                                                <div class="form-group col-md-6 ">
                                                    <label for="item">Item Selection</label>
                                                    <select class="form-control" id="item" name="item">
                                                        <option disabled selected>Select Item</option>

                                                        {{-- @foreach (getPurchaseItemList() as $key=>$value)
                                                        <option value="{{$key}}">{{$value}}</option>

                                                        @endforeach --}}
                                                    </select>
                                                </div>

                                            </div>


                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> Message </label>
                                                <textarea type="text" required class="form-control"
                                                    style="min-height: 100px;" name="message" row="8" value=""
                                                    placeholder="Type your message"></textarea>
                                            </div>



                                            <div class="form-group">
                                                <label for="exampleInputEmail1">File Upload(optional)</label>
                                                <input type="file" class="form-control" name="file" accept="image/*"
                                                    onchange="checkFileSize(this)">
                                                <span class="text-danger" id="fileSizeMsg"></span>
                                            </div>

                                            <div class="form-group float-right">
                                                <button type="submit" class="btn btn-sm btn-primary">Submit<i
                                                        class="fa-solid fa-paper-plane ml-2"></i></button>
                                            </div>






                                            <script>
                                                function checkFileSize(input) {
                                                    const maxFileSize = 1000000;
                                                    const fileSize = input.files[0].size;

                                                    if (fileSize > maxFileSize) {
                                                        document.getElementById('fileSizeMsg').innerText =
                                                            'Maximum upload size is 1000KB.';
                                                        input.value = '';
                                                    } else {
                                                        document.getElementById('fileSizeMsg').innerText = '';
                                                    }
                                                }

                                            </script>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class=" mt-3">


            @if(count($ticket) > 0) <div class="card p-1">
                <div class="card-header">
                    <h6>Ticket list</h6>
                </div>
                <table class="table  table-bordered mb-1">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Item</th>
                            {{-- <th>Image</th> --}}
                            <th>Last Update</th>


                        </tr>
                    </thead>
                    <tbody>



                        @foreach($ticket as $tickets)

                        <tr>

                            <td>
                                <strong style="text-transform: uppercase"><a
                                        href="tickets/{{$tickets->id}}">#{{$tickets->id}} -
                                        {{$tickets->category}}</a></strong>
                            </td>
                            <td>{{$tickets->department}}</td>
                            <td>{{$tickets->status}}</td>
                            <td>
                                @if($tickets->purchaseitem)
                                {{$tickets->purchaseitem->name}} <br>
                                <span class="badge badge-info">{{$tickets->purchaseitem->service_type}}</span>
                                @endif
                            </td>
                            {{-- <td style="width: 10%">
                                @if($tickets->asset)
                                <img width="100px" height="50px" src="{{ asset($tickets->asset->image_path) }}"
                                    class="img-fluid" alt="Ticket Image">
                                @else
                                <input type="text" class="form-control" readonly placeholder="No Image">
                                @endif
                            </td> --}}
                            <td>
                                @php
                                $cTime = now();
                                $lReplyTime = $tickets->updated_at;
                                $tDifference = $cTime->diff($lReplyTime);
                                @endphp
                                <p class="badge bg-secondary">
                                    {{ $tDifference->h }} Hours
                                    {{ $tDifference->i }} Minutes
                                    {{ $tDifference->s }} Seconds Ago
                                </p>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table> {{$ticket->links()}}

                @else
                <h5 style="color: red;">No Tickets to Show.</h5>
                @endif
            </div>


        </div>




    </div>
</div>
</div>
</div>
<script src="{{url('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script type="text/javascript">
    $('.table').DataTable({
       "pageLength": 10,
       "paging" : false,
       "ordering": false,
       "responsive":true,
       "language": {
    "searchPlaceholder": "Find By Data..."
    }
     });
</script>
    <!-- Bootstrap JS (optional) -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>