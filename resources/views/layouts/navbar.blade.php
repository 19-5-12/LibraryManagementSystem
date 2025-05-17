@php $loggedIn = session('student_id'); @endphp
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('browse.books') }}">Library Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('browse.books') }}">Browse Books</a>
                </li>
                @if($loggedIn)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('book.status') }}">Book Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('meeting.form') }}">Meeting Room Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('meeting.status') }}">Meeting Room Booking Status</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="display:inline;cursor:pointer;">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('student.register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav> 