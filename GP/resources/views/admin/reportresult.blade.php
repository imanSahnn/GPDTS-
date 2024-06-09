@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Report Results</h2>
    @if($results->isEmpty())
        <p>No results found.</p>
    @else
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    @switch($reportType)
                        @case('bookings')
                            <th class="py-2 px-4 border-b border-gray-200">Student Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Tutor Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Course Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200">Time</th>
                            <th class="py-2 px-4 border-b border-gray-200">Status</th>
                            @break
                        @case('payments')
                            <th class="py-2 px-4 border-b border-gray-200">Student Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Course Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Total Payment</th>
                            <th class="py-2 px-4 border-b border-gray-200">Status</th>
                            @break
                        @case('final_assessments')
                            <th class="py-2 px-4 border-b border-gray-200">Student Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Course Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Final Date</th>
                            <th class="py-2 px-4 border-b border-gray-200">Status A</th>
                            <th class="py-2 px-4 border-b border-gray-200">Status B</th>
                            @break
                        @case('students')
                            <th class="py-2 px-4 border-b border-gray-200">Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Email</th>
                            <th class="py-2 px-4 border-b border-gray-200">IC</th>
                            <th class="py-2 px-4 border-b border-gray-200">Phone Number</th>
                            @break
                        @case('tutors')
                            <th class="py-2 px-4 border-b border-gray-200">Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Email</th>
                            <th class="py-2 px-4 border-b border-gray-200">IC</th>
                            <th class="py-2 px-4 border-b border-gray-200">Phone Number</th>
                            @break
                    @endswitch
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        @switch($reportType)
                            @case('bookings')
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->student->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->tutor->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->course->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->date }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->time }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->status }}</td>
                                @break
                            @case('payments')
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->student->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->course->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->total_payment }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->status }}</td>
                                @break
                            @case('final_assessments')
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->student->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->course->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->final_date }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->final_statusA }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->final_statusB }}</td>
                                @break
                            @case('students')
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->ic }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->number }}</td>
                                @break
                            @case('tutors')
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->ic }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $result->number }}</td>
                                @break
                        @endswitch
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection


