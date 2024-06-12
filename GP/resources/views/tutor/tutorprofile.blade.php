@extends('tutor.layout')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h1 class="mb-6 text-center text-4xl font-bold text-gray-800">Profile</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl mx-auto">
        <div class="flex justify-center mb-6">
            @if($tutor->picture)
                <img src="{{ asset('storage/' . $tutor->picture) }}" alt="Profile Picture" class="rounded-full w-32 h-32 object-cover">
            @else
                <span class="text-gray-500">No Profile Picture</span>
            @endif
        </div>

        <form action="{{ route('tutor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">Name:</td>
                        <td><input type="text" id="name" name="name" value="{{ $tutor->name }}" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled></td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">IC:</td>
                        <td><input type="text" id="ic" name="ic" value="{{ $tutor->ic }}" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled></td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">Phone Number:</td>
                        <td><input type="text" id="number" name="number" value="{{ $tutor->number }}" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">Email:</td>
                        <td><input type="email" id="email" name="email" value="{{ $tutor->email }}" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">Password:</td>
                        <td><input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">Confirm Password:</td>
                        <td><input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 font-bold p-2">New Picture:</td>
                        <td><input type="file" id="picture" name="picture" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></td>
                    </tr>
                </tbody>
            </table>

            <div class="flex items-center justify-center mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded focus:outline-none focus:shadow-outline">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
