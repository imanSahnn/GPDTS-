<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor List</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
@extends('layout.app')

@section('title', 'Tutor List')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Tutor List</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($tutors as $tutor)
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <img src="{{ asset('storage/' . $tutor->picture) }}" alt="{{ $tutor->name }}" class="w-full h-48 object-cover mb-4 rounded-lg">
            <h2 class="text-2xl font-bold mb-2 text-gray-800">{{ $tutor->name }}</h2>
            <p class="text-gray-600 mb-2">Course: {{ $tutor->course->name }}</p>
            <p class="text-gray-600 mb-2">Phone Number: {{ $tutor->number }}</p>
            <p class="text-gray-600 mb-2">Average Rating: {{ number_format($tutor->average_rating, 2) }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
</body>
</html>
