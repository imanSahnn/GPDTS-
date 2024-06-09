<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Homepage</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <style>
        .booking-card {
            background-color: #fff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script>
        function updateClock() {
            const options = { timeZone: 'Asia/Kuala_Lumpur', hour12: true, weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const now = new Date().toLocaleString('en-US', options);
            document.getElementById('clock').innerText = now;
        }

        setInterval(updateClock, 1000);
        document.addEventListener('DOMContentLoaded', updateClock);
    </script>
</head>
<body>
    @extends('tutor.layout')

    @section('title', 'Homepage')

    @section('content')
    <div id="clock" class="text-6xl font-bold text-center"></div>
    <div class="max-w-md w-full mx-auto">
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="booking-card">
                <h2 class="text-xl font-semibold mb-2">Today's Bookings</h2>
                @if ($todaysBookings->isEmpty())
                    <p>No bookings for today.</p>
                @else
                    @foreach ($todaysBookings as $booking)
                        <div class="mb-4">
                            <p><strong>Student:</strong> <a href="{{ route('tutor.studentdetail', ['id' => $booking->student->id, 'bookingId' => $booking->id]) }}">{{ $booking->student->name }}</a></p>
                            <p><strong>Date:</strong> {{ $booking->date }}</p>
                            <p><strong>Time:</strong> {{ $booking->time }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="booking-card">
                <h2 class="text-xl font-semibold mb-2">Tomorrow's Bookings</h2>
                @if ($tomorrowsBookings->isEmpty())
                    <p>No bookings for tomorrow.</p>
                @else
                    @foreach ($tomorrowsBookings as $booking)
                        <div class="mb-4">
                            <p><strong>Student:</strong> <a href="{{ route('tutor.studentdetail', ['id' => $booking->student->id, 'bookingId' => $booking->id]) }}">{{ $booking->student->name }}</a></p>
                            <p><strong>Date:</strong> {{ $booking->date }}</p>
                            <p><strong>Time:</strong> {{ $booking->time }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @endsection

</body>
</html>
