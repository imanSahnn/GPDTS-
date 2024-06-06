@extends('admin.layout')

@section('title', 'View Student')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
        View student
    </h1>

    <div class="space-y-4 md:space-y-6">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
            <p id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                {{ $student->name }}
            </p>
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
            <p id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                {{ $student->email }}
            </p>
        </div>
        <div>
            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900">IC</label>
            <p id="ic" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                {{ $student->ic }}
            </p>
        </div>
        <div>
            <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Phone Number</label>
            <p id="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                {{ $student->number }}
            </p>
        </div>
        <div>
            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900">Profile Picture</label>
            @if ($student->picture)
                <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="block w-full max-w-xs h-auto rounded-lg">
            @else
                <p class="text-gray-500">No picture available</p>
            @endif
        </div>
    </div>
@endsection
