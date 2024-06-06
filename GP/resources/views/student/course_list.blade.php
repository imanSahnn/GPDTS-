@extends('student.layout')

@section('title', 'Course List')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Available Courses</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($courses as $course)
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <img src="{{ asset('storage/' . $course->picture) }}" alt="{{ $course->name }}" class="w-full h-48 object-cover mb-4 rounded-lg">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $course->name }}</h2>
            <p class="text-gray-600 mb-2">Price: ${{ $course->price }}</p>
            <p class="text-gray-600 mb-2">Minimum Hours: {{ $course->min_hours }}</p>
            <p class="text-gray-600 mb-4">{{ $course->detail }}</p>
            <form action="{{ route('choose_course') }}" method="POST" onsubmit="return confirmChooseCourse()">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Choose</button>
            </form>
        </div>
        @endforeach
    </div>
</div>

<script>
    function confirmChooseCourse() {
        return confirm('Are you sure you want to choose this course?');
    }
</script>
@endsection
