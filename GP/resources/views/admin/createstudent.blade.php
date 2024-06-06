@extends('admin.layout')

@section('title', 'Add student')

@section('content')
    <h1>Add student</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
        Create Account
    </h1>
    <form action="{{ route('admin.storestudent') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your name</label>
            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name" required="">
            @error('name')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">
            @error('email')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
            @error('password')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm password</label>
            <input type="confirm-password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">
            @error('password_confirmation')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900">Your IC</label>
            <input type="text" name="ic" id="ic" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="020700012033" required="">
            @error('ic')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Your phone number</label>
            <input type="text" name="number" id="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="01139144048" required="">
            @error('number')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="course_id" class="block mb-2 text-sm font-medium text-gray-900">Choose Course</label>
            <select name="course_id" id="course_id" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            @error('course_id')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Profile Picture</label>
            <input type="file" name="picture" id="picture" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
            @error('picture')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create an account</button>
    </form>
</div>
</div>
</div>
</section>
@endsection
