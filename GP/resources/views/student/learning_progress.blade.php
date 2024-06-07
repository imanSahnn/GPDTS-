@extends('layout.app')

@section('title', 'Learning Progress')

@section('content')
<div class="container mx-auto mt-5 px-4">
    <h1 class="mb-4 text-center text-3xl font-bold">Learning Progress</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
        <!-- Skills Section -->
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-semibold">Skills</h3>
            @foreach($courses as $course)
                <div class="mb-5">
                    <!-- Course Title -->
                    <div class="bg-blue-600 text-white p-3 rounded-t">
                        <h2 class="mb-0 text-xl">{{ $course->name }}</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full ">
                            <thead>
                                <tr>
                                    <th class="border px-4 py-2">Skill</th>
                                    <th class="border px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($course->skills as $skill)
                                    @php
                                        $statusKey = $course->id . '-' . $skill->id;
                                        $status = $skillsProgress[$statusKey]->status_skill ?? 'Not Started';
                                    @endphp
                                    <tr>
                                        <td class="border px-4 py-2">{{ $skill->skill_name }}</td>
                                        <td class="border px-4 py-2 text-center">
                                            <span class="inline-block px-8 py-1 rounded-full text-white text-lg
                                                @if($status === 'pass') bg-green-500
                                                @elseif($status === 'fail') bg-red-500
                                                @elseif($status === 'in_progress') bg-yellow-500
                                                @else bg-gray-500
                                                @endif">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bookings Section -->
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-semibold">Bookings</h3>
            @if($allBookings->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="table-auto w-full mt-3">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">Course Name</th>
                                <th class="border px-4 py-2">Date</th>
                                <th class="border px-4 py-2">Time</th>
                                <th class="border px-4 py-2">Attendance</th>
                                <th class="border px-4 py-2">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allBookings as $booking)
                                <tr>
                                    <td class="border px-4 py-2">{{ $booking->course_name }}</td>
                                    <td class="border px-4 py-2">{{ $booking->date }}</td>
                                    <td class="border px-4 py-2">{{ $booking->time }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($booking->attendance_status) }}</td>
                                    <td class="border px-4 py-2">{{ $booking->comment }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="mt-3">No bookings available.</p>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
    .status-badge {
        padding: 10px 20px;
        font-size: 1.25rem;
        border-radius: 9999px; /* Full rounding for oval shape */
    }

    .bg-green-500 {
        background-color: #38a169;
    }

    .bg-red-500 {
        background-color: #e53e3e;
    }

    .bg-yellow-500 {
        background-color: #ecc94b;
    }

    .bg-gray-500 {
        background-color: #a0aec0;
    }

    .text-center {
        text-align: center;
    }
</style>
