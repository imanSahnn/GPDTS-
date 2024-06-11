<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
    @extends('layout.app')

    @section('title', 'Homepage')

    @section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center mt-8">Welcome to the Homepage</h2>
    <!-- Lesen Picture and Date Upload Section -->
    <div class="mb-8">
        <h3 class="text-2xl font-bold mb-4">Upload Lesen Picture and Date</h3>
        @if($student->lesen_picture_status == 'rejected' || !$student->lesen_picture)
            <form action="{{ route('uploadLesen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="lesen_picture">Lesen Picture:</label>
                    <input type="file" id="lesen_picture" name="lesen_picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="lesen_picture_date">Date:</label>
                    <input type="date" id="lesen_picture_date" name="lesen_picture_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Submit
                    </button>
                </div>
            </form>
        @else
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Current Lesen Picture:</label>
                <img src="{{ asset('storage/' . $student->lesen_picture) }}" alt="Lesen Picture" class="rounded-full w-32 h-32">
            </div>
            @if($student->lesen_picture_status == 'pending')
                <p class="text-yellow-500 font-bold">Your submission is pending.</p>
            @elseif($student->lesen_picture_status == 'approved')
                <p class="text-green-500 font-bold">Your submission is approved.</p>
            @endif
        @endif
    </div>

        <!-- Approved Bookings Section -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-4">Approved Bookings</h3>
            @if($approvedBookings->isEmpty())
                <p class="text-center text-gray-600">No approved bookings found.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($approvedBookings as $booking)
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $booking->tutor->name }}</h2>
                        <p class="text-gray-600 mb-2">Course: {{ $booking->course->name }}</p>
                        <p class="text-gray-600 mb-2">Date: {{ $booking->date }}</p>
                        <p class="text-gray-600 mb-2">Time: {{ $booking->time }}</p>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Learning Progress Section -->
        <div class="mt-12">
            <h3 class="text-2xl font-bold mb-4">Learning Progress</h3>
            <div class="mb-4">
                <label for="courseSelect" class="block text-gray-700 text-sm font-bold mb-2">Select Course:</label>
                <select id="courseSelect" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $selectedCourseId == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full max-w-lg mx-auto">
                <canvas id="learningProgressChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // GSAP animation for logo
            gsap.fromTo("#companyLogo", { opacity: 0, x: -100 }, { opacity: 1, x: 0, duration: 1.5 });

            // Initialize Chart.js
            var ctx = document.getElementById('learningProgressChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['In Progress', 'Pass'],
                    datasets: [{
                        label: 'Learning Progress',
                        data: [
                            {{ $progressData['in_progress'] ?? 0 }},
                            {{ $progressData['pass'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#FFCE56',
                            '#36A2EB'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Learning Progress'
                        }
                    }
                }
            });

            // Update chart on course selection change
            document.getElementById('courseSelect').addEventListener('change', function () {
                var courseId = this.value;
                fetch(`{{ url('/update-progress') }}?course_id=${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        chart.data.datasets[0].data = [
                            data.progressData['in_progress'] || 0,
                            data.progressData['pass'] || 0
                        ];
                        chart.update();
                    });
            });
        });
    </script>
    @endsection
</body>
</html>
