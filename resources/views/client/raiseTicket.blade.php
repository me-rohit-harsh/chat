<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Raise Tickets</title>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Font Awesome CSS -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>
    <!-- Custome css  -->
    <link rel='stylesheet' href='style.css'>
</head>

<body>

    <!-- Your HTML content here -->
    <div class="row mx-2">

        <div class="col-sm-10 container mt-2">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <a class="btn btn-success mb-3" type="button" href="{{route('user.Ticket')}}">Tickets List</a>
            <div class="card p-1 mb-2">
                <div class="card-header">
                    <h5 class="card-title" id="raiseTicketModalLabel">Raise Ticket</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('add.tickets')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Subject</label>
                                    <input type="text" required class="form-control" id="category" name="category"
                                        placeholder="Enter Subject here...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department">Department</label>
                                    <select class="form-control" id="department" name="department">
                                        <option value="General Query">General Query</option>
                                        <option value="Support">Support </option>
                                        <option value="Technical Support">Technical Support</option>
                                        <option value="Sales Team">Sales Team</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message">Message</label>
                            <textarea required class="form-control" id="message" style="min-height: 100px;"
                                name="message" placeholder="Type your message"></textarea>
                        </div>
                        {{-- File Upload(optional) --}}
                        {{-- <div class="form-group">
                            <label for="file">File Upload(optional)</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept="image/*"
                                onchange="checkFileSize(this)">
                            <small class="text-danger" id="fileSizeMsg"></small>
                        </div> --}}
                        <div class="form-group float-right">
                            <button type="submit" class="btn btn-primary">Submit<i
                                    class="fa-solid fa-paper-plane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>




        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>