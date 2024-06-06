<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('admin.layout')

    @section('title', 'Homepage')

    @section('content')
        <h2>Welcome to the Homepage</h2>
        <p>This is the content of the homepage.</p>
    @endsection
</body>
</html>
