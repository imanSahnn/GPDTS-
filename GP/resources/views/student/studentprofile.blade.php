@extends('layout.app')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto mt-5 px-4">
    <h1 class="mb-4 text-center text-3xl font-bold">Profile</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white p-6 rounded shadow mb-4">
            <div class="mb-4 text-center">
                <label class="block text-gray-700 font-bold text-xl mb-2">Status:</label>
                <span class="text-lg">{{ $student->status }}</span>
            </div>
            @if($student->picture)
            <div class="mb-4 flex justify-center">
                <div>
                    <label class="block text-gray-700 text-center font-bold mb-1">Current Profile Picture:</label>
                    <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="rounded-full w-32 h-32">
                </div>
            </div>
        @endif
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="picture">Profile Picture:</label>
                <input type="file" id="picture" name="picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ $student->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="ic">IC:</label>
                <input type="text" id="ic" name="ic" value="{{ $student->ic }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="number">Phone Number:</label>
                <input type="text" id="number" name="number" value="{{ $student->number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ $student->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="password">Password:</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Courses:</label>
                <ul>
                    @foreach($student->courses->unique('id') as $course)
                        <li>{{ $course->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endsection
