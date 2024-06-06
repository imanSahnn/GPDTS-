<!DOCTYPE html>
<html>
<head>
    <title>tutor status</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('admin.layout')

    @section('title', 'Homepage')

    @section('content')


<form action="{{ route('admin.update-tutor-availability') }}" method="post">
    @csrf
    <select name="tutor_id">
        @foreach ($tutors as $tutor)
            <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
        @endforeach
    </select>
    <input type="date" name="start_date">
    <input type="date" name="end_date">
    <button type="submit">Update Availability</button>
</form>

    @endsection
</body>
</html>
