<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<!-- Custom CSS -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                    <!-- Your HTML content here -->
                    <section class="jumbotron text-center d-flex align-items-center">
                        <div class="container">
                            <h1 class="jumbotron-heading">Welcome to Live Chat</h1>
                            <p class="lead text-muted">Connect with your audience in real-time with our live chat web application.
                                Engage, support, and communicate with ease.</p>
                           <p class="text-center">
                                <strong>Chat Section: </strong>
                                <a href="{{route('admin.chat')}}" class="btn btn-primary my-2">Admin Side</a>
                                <a href="{{route('user.chat')}}" class="btn btn-secondary my-2">Client Side</a>
                            </p>
                            <p class="text-center">
                                <strong>Ticket Section: </strong>
                                <a href="{{route('admin.ticket')}}" class="btn btn-primary my-2">Admin Side</a>
                                <a href="{{route('user.raiseTicket')}}" class="btn btn-secondary my-2">Client Side</a>
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        Echo.private('MessageUpdate')
    .listen('ChatEvent', (event) => {
    console.log("User Msg: ".event);
    });
    </script>
</x-app-layout>
