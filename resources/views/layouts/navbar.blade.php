@php $loggedIn = session('student_id'); @endphp
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('browse.books') }}">Library Management System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('browse.books') || request()->routeIs('book.status') ? 'active' : '' }}" href="#" id="booksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Browse Books
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="booksDropdown">
                        <li><a class="dropdown-item {{ request()->routeIs('browse.books') ? 'active' : '' }}" href="{{ route('browse.books') }}">Browse Books</a></li>
                        <li><a class="dropdown-item {{ request()->routeIs('book.status') ? 'active' : '' }}" href="{{ route('book.status') }}">Book Status</a></li>
                    </ul>
                </li>
                @if($loggedIn)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('meeting.form') || request()->routeIs('meeting.status') ? 'active' : '' }}" href="#" id="meetingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Meeting Room Bookings
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="meetingDropdown">
                            <li><a class="dropdown-item {{ request()->routeIs('meeting.form') ? 'active' : '' }}" href="{{ route('meeting.form') }}">Book a Room</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('meeting.status') ? 'active' : '' }}" href="{{ route('meeting.status') }}">Booking Status</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline" id="logout-form">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="display:inline;cursor:pointer;">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('student.register') ? 'active' : '' }}" href="{{ route('student.register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                if (!confirm('Are you sure you want to log out?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
<style>
    .navbar {
        box-shadow: 0 2px 8px rgba(25, 118, 210, 0.1);
    }
    .navbar-brand {
        font-weight: bold;
        letter-spacing: 1px;
    }
    .nav-link {
        transition: color 0.2s;
    }
    .nav-link.active, .nav-link:focus, .nav-link:hover {
        color: #ffd600 !important;
        background: rgba(255,255,255,0.08);
        border-radius: 4px;
    }
    .nav-link.active {
        background: rgba(0,0,0,0.18) !important;
        color: #fff !important;
        font-weight: bold;
    }
    .navbar-nav .nav-item + .nav-item {
        margin-left: 0.5rem;
    }
    .dropdown-menu {
        background-color: #0d6efd;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .dropdown-item {
        color: #fff;
        padding: 0.5rem 1rem;
    }
    .dropdown-item:hover, .dropdown-item:focus {
        background-color: rgba(255,255,255,0.1);
        color: #ffd600;
    }
    .dropdown-item.active {
        background-color: rgba(0,0,0,0.18);
        color: #fff;
        font-weight: bold;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 