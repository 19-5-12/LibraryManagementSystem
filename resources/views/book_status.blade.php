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
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
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
                    @if($book->status === 'Approved')
                        <span class="badge bg-success">{{ $book->status }}</span>
                        @if(isset($pendingExtends[$book->request_id]))
                            @php $ext = $pendingExtends[$book->request_id]; @endphp
                            @if($ext->status === 'Pending')
                                <span class="badge bg-warning text-dark ms-2">Extend Return Due Pending</span>
                            @elseif($ext->status === 'Approved')
                                <span class="badge bg-success ms-2">Extend Return Due Approved</span>
                            @elseif($ext->status === 'Declined')
                                <span class="badge bg-danger ms-2">Extend Return Due Declined</span>
                            @endif
                        @else
                            <form action="{{ route('extend.request') }}" method="POST" class="d-inline ms-2">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $book->request_id }}">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Extend Return Due Request</button>
                            </form>
                        @endif
                    @elseif($book->status === 'Pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-danger">{{ $book->status }}</span>
                    @endif
                </td>
            </tr>
            {{-- DEBUG: REQUEST_ID = {{ $book->request_id }} --}}
        @endforeach
        </tbody>
    </table>
    <div class="text-center text-muted">Status of borrowed books</div>
</div>
</body>
</html> 