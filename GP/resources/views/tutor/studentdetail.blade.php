<!-- studentdetail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <style>
        .container {
            display: grid;
            grid-template-areas:
                "date time"
                "student attendance"
                "progress progress";
            gap: 1rem;
            padding: 2rem;
        }

        .date, .time {
            grid-area: date;
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .time {
            grid-area: time;
        }

        .student {
            grid-area: student;
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .attendance {
            grid-area: attendance;
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress {
            grid-area: progress;
            background-color: #fff;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100">
    @extends('tutor.layout')

    @section('title', 'Student Details')

    @section('content')
    <div class="container">
        <!-- Date Section -->
        <div class="date">
            <p class="text-xl"><strong>Date:</strong> <span id="modalDate">{{ $selectedBooking->date ?? 'N/A' }}</span></p>
        </div>

        <!-- Time Section -->
        <div class="time">
            <p class="text-xl"><strong>Time:</strong> <span id="modalTime">{{ $selectedBooking->time ?? 'N/A' }}</span></p>
        </div>

        <!-- Student Details Section -->
        <div class="student">
            <h2 class="text-3xl font-bold mb-6">Student Details</h2>
            <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="mx-auto mb-6">
            <p class="text-xl font-medium">
                Name:
                <a href="{{ route('tutor.showStudent', $student->id) }}" class="text-blue-500 hover:underline">{{ $student->name }}</a>
            </p>
            <p class="text-xl">Phone Number: {{ $student->number }}</p>
            <p class="text-xl">Email: {{ $student->email }}</p>
        </div>

        <!-- Attendance and Comments Section -->
        <div class="attendance">
            <h2 class="text-3xl font-bold mb-6">Attendance and Comments</h2>
            @if ($allBookings->isEmpty())
                <p>No bookings available.</p>
            @else
                @foreach ($allBookings as $booking)
                <form method="POST" action="{{ route('update_booking', $booking->id) }}" id="updateBookingForm-{{ $booking->id }}">
                    @csrf
                    <input type="hidden" name="booking_id" id="bookingId" value="{{ $booking->id }}">
                    <div class="mb-4">
                        <label for="attendance_status-{{ $booking->id }}" class="block text-gray-700 text-sm font-bold mb-2">Attendance Status:</label>
                        <select name="attendance_status" id="attendance_status-{{ $booking->id }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="present" {{ $booking->attendance_status == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ $booking->attendance_status == 'absent' ? 'selected' : '' }}>Absent</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="comment-{{ $booking->id }}" class="block text-gray-700 text-sm font-bold mb-2">Comment:</label>
                        <textarea name="comment" id="comment-{{ $booking->id }}" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $booking->comment }}</textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" id="saveButton-{{ $booking->id }}">Save</button>
                    </div>
                </form>
                @endforeach
            @endif
        </div>

        <!-- Learning Progress Section -->
        <div class="progress">
            <h2 class="text-3xl font-bold mb-6">Learning Progress</h2>
            @if ($skillsProgress->isEmpty())
                <p>No skills assigned yet.</p>
            @else
                <form method="POST" action="{{ route('update_all_skills') }}" id="updateSkillsForm">
                    @csrf
                    <ul class="list-disc pl-8 mb-6">
                        @foreach ($skillsProgress as $progress)
                            <li class="text-xl mb-4">{{ $progress->skill->skill_name }} -
                                <select name="skills[{{ $progress->id }}]" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="in_progress" {{ $progress->status_skill == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="pass" {{ $progress->status_skill == 'pass' ? 'selected' : '' }}>Pass</option>
                                    <option value="fail" {{ $progress->status_skill == 'fail' ? 'selected' : '' }}>Fail</option>
                                </select>
                            </li>
                        @endforeach
                    </ul>
                    <div class="flex items-center justify-between">
                        <button type="button" id="saveAllButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save All</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const now = new Date();

            @foreach ($allBookings as $booking)
            const bookingDate{{ $booking->id }} = new Date('{{ $booking->date }} {{ $booking->time }}');

            if (now >= bookingDate{{ $booking->id }}) {
                document.getElementById('attendance_status-{{ $booking->id }}').removeAttribute('disabled');
                document.getElementById('comment-{{ $booking->id }}').removeAttribute('disabled');
                document.getElementById('saveButton-{{ $booking->id }}').removeAttribute('disabled');
            } else {
                document.getElementById('attendance_status-{{ $booking->id }}').setAttribute('disabled', 'disabled');
                document.getElementById('comment-{{ $booking->id }}').setAttribute('disabled', 'disabled');
                document.getElementById('saveButton-{{ $booking->id }}').setAttribute('disabled', 'disabled');
            }
            @endforeach

            document.getElementById('saveAllButton').addEventListener('click', function () {
                const confirmation = confirm('Are you sure you want to save all skill changes? This action cannot be undone.');
                if (confirmation) {
                    document.getElementById('saveAllButton').setAttribute('disabled', 'disabled');
                    document.getElementById('updateSkillsForm').submit();
                }
            });
        });
    </script>
</body>
</html>
