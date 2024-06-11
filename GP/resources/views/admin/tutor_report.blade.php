@extends('admin.layout')

@section('title', 'Tutor Report')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center mt-8">Tutor Report</h2>
        @if($tutors->isEmpty())
            <p class="text-center">No tutors found with the selected criteria.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Name</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Courses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tutors as $tutor)
                        <tr>
                            <td class="py-2">{{ $tutor->name }}</td>
                            <td class="py-2">{{ $tutor->email }}</td>
                            <td class="py-2">{{ $tutor->course->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
