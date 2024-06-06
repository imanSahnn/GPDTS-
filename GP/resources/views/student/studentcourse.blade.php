<!-- resources/views/courses.blade.php -->

@extends('student.layout')

@section('content')
<div class="container">
    <h2>Available Courses</h2>
    <div class="row">
        @foreach($courses as $course)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $course->image_url }}" class="card-img-top" alt="{{ $course->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->name }}</h5>
                    <p class="card-text">Price: ${{ $course->price }}</p>
                    <p class="card-text">Minimum Hours: {{ $course->minimum_hour }}</p>
                    <p class="card-text">{{ $course->details }}</p>
                    <form action="{{ route('bookCourse') }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <button type="submit" class="btn btn-primary">Book Class</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
