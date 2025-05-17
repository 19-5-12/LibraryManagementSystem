@include('layouts.navbar')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Meeting Room Booking Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h2 class="text-center mb-4">Meeting Room Booking Status</h2>
    @if(count($bookings) > 0)
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>Room</th>
                    <th>Booking Date</th>
                    <th>Time From</th>
                    <th>Time To</th>
                </tr>
            </thead>
            <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->room_id }}</td>
                    <td>{{ $booking->book_date }}</td>
                    <td>{{ $booking->time_from }}</td>
                    <td>{{ $booking->time_to }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info text-center">No meeting room bookings found.</div>
    @endif
</div>
</body>
</html> 