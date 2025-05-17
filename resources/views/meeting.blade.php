<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Room Booking</title>
    <!-- Bootstrap CSS is now included globally -->
</head>
<body class="bg-light">
    @include('layouts.navbar')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">Meeting Room Booking</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('meeting') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="room_id" class="form-label">Select Room (1-5)</label>
                                <select class="form-select" id="room_id" name="room_id" required>
                                    <option value="">Choose a room</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">Room {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="time_from" class="form-label">Date and Time (Start)</label>
                                <input type="datetime-local" class="form-control" id="time_from" name="time_from" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info">Book Room</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS is now included globally -->
</body>
</html> 