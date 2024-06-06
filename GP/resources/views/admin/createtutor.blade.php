@extends('admin.layout')

@section('title', 'Add Tutor')

@section('content')
    <div class="max-w-2xl mx-auto p-8 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Add Tutor</h1>

        @if (session('success'))
            <div class="alert alert-success p-4 mb-6 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.storetutor') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your name</label>
                <input type="text" name="name" id="name" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600" placeholder="Enter your name" required="">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600" placeholder="name@company.com" required="">
                @error('email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="••••••••" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600" required="" readonly>
                    <button type="button" onclick="generatePassword()" class="absolute inset-y-0 right-0 px-4 py-3 text-sm font-medium text-white bg-primary-600 rounded-r-lg hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300">Generate</button>
                </div>
                @error('password')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="ic" class="block mb-2 text-sm font-medium text-gray-900">Your IC</label>
                <input type="text" name="ic" id="ic" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600" placeholder="020700012033" required="">
                @error('ic')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Your phone number</label>
                <input type="text" name="number" id="number" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600" placeholder="01139144048" required="">
                @error('number')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Profile Picture</label>
                <input type="file" name="picture" id="picture" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600">
                @error('picture')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="course_id" class="block mb-2 text-sm font-medium text-gray-900">Course</label>
                <select name="course_id" id="course_id" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_id')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full py-3 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm text-center">Confirm</button>
        </form>
    </div>

    <script>
        function generatePassword() {
            var length = 12,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()",
                password = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                password += charset.charAt(Math.floor(Math.random() * n));
            }
            document.getElementById("password").value = password;
        }
    </script>
@endsection
