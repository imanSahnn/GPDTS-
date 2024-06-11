@extends('admin.layout')

@section('title', 'Generate Reports')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center mt-8">Generate Reports</h2>
        <form action="{{ route('admin.generateStudentReport') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 font-bold mb-2">Course:</label>
                <select name="course_id" id="course_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="tutor_id" class="block text-gray-700 font-bold mb-2">Tutor:</label>
                <select name="tutor_id" id="tutor_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Tutor</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Generate Student Report</button>
        </form>

        <form action="{{ route('admin.generateTutorReport') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 font-bold mb-2">Course:</label>
                <select name="course_id" id="course_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Generate Tutor Report</button>
        </form>

        <form action="{{ route('admin.generateCourseReport') }}" method="POST" class="mb-4">
            @csrf
            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 font-bold mb-2">Course:</label>
                <select name="course_id" id="course_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Generate Course Report</button>
        </form>
    </div>
@endsection
