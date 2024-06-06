<!DOCTYPE html>
<html>
<head>
    <title>Student</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('admin.layout')

    @section('title', 'Student Page')

    @section('content')
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1>student Page</h1>
                </div>
                <div class="col text-right">
                    <a href="{{ route('admin.createstudent') }}" class="btn btn-primary">Add New student</a>
                </div>
            </div>

            <p>This is the content of the student page.</p>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile Picture</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>
                                    @if($student->picture)
                                        <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" width="150">
                                    @else
                                        No Picture
                                    @endif
                                </td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->number }}</td>
                                <td>
                                    <a href="{{ route('admin.viewstudent', [$student->id]) }}" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{ route('admin.editstudent', [$student->id]) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.destroy', $student->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
</body>
</html>
