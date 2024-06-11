@extends('admin.layout')

@section('title', 'Course Report')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center mt-8">Course Report</h2>
        @if($courses->isEmpty())
            <p class="text-center">No courses found with the selected criteria.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2">Name</th>
                        <th class="py-2">Price</th>
                        <th class="py-2">Details</th>
                        <th class="py-2">Minimum Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td class="py-2">{{ $course->name }}</td>
                            <td class="py-2">{{ $course->price }}</td>
                            <td class="py-2">{{ $course->detail }}</td>
                            <td class="py-2">{{ $course->minimum_hour }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
