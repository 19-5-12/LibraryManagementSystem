@include('layouts.navbar')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .nav-tabs .nav-link.active { background: #1976d2; color: #fff; }
        .nav-tabs .nav-link { color: #1976d2; }
    </style>
</head>
<body>
<div class="container py-4">
    <h2 class="text-center mb-4">Library Management System</h2>
    <ul class="nav nav-tabs justify-content-center mb-4">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('browse.books') }}">Browse Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('book.status') }}">Book Status</a>
        </li>
    </ul>
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $book->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">by {{ $book->author }}</h6>
                        <p class="card-text">{{ $book->description ?? '' }}</p>
                        <p class="mb-1"><strong>Year:</strong> {{ isset($book->publication_year) ? date('Y', strtotime($book->publication_year)) : '' }} • <strong>Genre:</strong> {{ $book->category ?? '' }}</p>
                        @if($book->status === 'available')
                            @if($studentId)
                                <form action="{{ route('request.book') }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled=true; return confirm('Are you sure you want to borrow this book?');">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->book_id }}">
                                    <button type="submit" class="btn btn-primary">Borrow</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">Borrow</a>
                            @endif
                        @elseif($book->status === 'pending')
                            <button class="btn btn-warning" disabled>Pending</button>
                        @else
                            <button class="btn btn-secondary" disabled>Borrowed</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html> 