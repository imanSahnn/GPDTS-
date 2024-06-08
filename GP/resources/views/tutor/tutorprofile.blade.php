<!-- tutorprofile.blade.php -->
@extends('tutor.layout')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto mt-5 px-4">
    <h1 class="mb-4 text-center text-3xl font-bold">Profile</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tutor.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white p-6 rounded shadow mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ $tutor->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="ic">IC:</label>
                <input type="text" id="ic" name="ic" value="{{ $tutor->ic }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="number">Phone Number:</label>
                <input type="text" id="number" name="number" value="{{ $tutor->number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ $tutor->email }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
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
                <label class="block text-gray-700 font-bold mb-2" for="picture">Picture:</label>
                <input type="file" id="picture" name="picture" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            @if($tutor->picture)
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Current Picture:</label>
                    <img src="{{ asset('storage/' . $tutor->picture) }}" alt="Profile Picture" class="rounded-full w-32 h-32">
                </div>
            @endif

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endsection
