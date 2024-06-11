@extends('admin.layout')

@section('title', 'Student Report')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center mt-8">Student Report</h2>
        @if($students->isEmpty())
            <p class="text-center">No students found with the selected criteria.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Courses</th>
                        <th class="py-2">Tutor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="py-2">{{ $student->name }}</td>
                            <td class="py-2">{{ $student->email }}</td>
                            <td class="py-2">
                                @foreach($student->courses as $course)
                                    {{ $course->name }}<br>
                                @endforeach
                            </td>
                            <td class="py-2">
                                @foreach($student->bookings as $booking)
                                    {{ $booking->tutor->name }}<br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
