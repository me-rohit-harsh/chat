<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Web Application</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Your HTML content here -->
    <section class="jumbotron text-center d-flex align-items-center">
        <div class="container">
            <h1 class="jumbotron-heading">Welcome to Live Chat</h1>
            <p class="lead text-muted">Connect with your audience in real-time with our live chat web application.
                Engage, support, and communicate with ease.</p>
            <p>
                <a href="{{route('admin.chat')}}" class="btn btn-primary my-2" target="_blank">Admin Side</a>
                <a href="{{route('user.chat')}}" class="btn btn-secondary my-2" target="_blank">Client Side</a>
            </p>
        </div>
    </section>
    <script>
        Echo.private('MessageUpdate')
.listen('ChatEvent', (event) => {
console.log(event.chat);
});
    </script>
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>