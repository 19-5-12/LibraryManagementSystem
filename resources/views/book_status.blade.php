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
            <a class="nav-link" href="{{ route('browse.books') }}">Browse Books</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('book.status') }}">Book Status</a>
        </li>
    </ul>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Date Borrowed</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($borrowedBooks as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->date_borrowed }}</td>
                <td>
                    @php
                        $status = strtoupper($book->status);
                    @endphp
                    @if($status === 'ACCEPTED' || $status === 'APPROVED')
                        <span class="badge bg-success">{{ $book->status }}</span>
                    @elseif($status === 'PENDING')
                        <span class="badge bg-warning text-dark">PENDING</span>
                    @else
                        <span class="badge bg-danger">{{ $book->status }}</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="text-center text-muted">Status of borrowed books</div>
</div>
</body>
</html> 