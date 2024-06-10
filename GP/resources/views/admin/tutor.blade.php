@extends('admin.layout')

@section('title', 'Tutors')

@section('content')
<div class="container mt-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-[#004225]">Approved Tutors</h1>
        <a href="{{ route('admin.createtutor') }}" class="btn btn-primary">Add New Tutor</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="bg-[#FFCF9D]">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>IC</th>
                    <th>Phone Number</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tutors as $tutor)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td>{{ $tutor->name }}</td>
                        <td>{{ $tutor->email }}</td>
                        <td>{{ $tutor->ic }}</td>
                        <td>{{ $tutor->number }}</td>
                        <td>{{ $tutor->course->name }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.edittutor', [$tutor->id]) }}" class="btn btn-sm btn-secondary">Edit</a>
                            <form action="{{ route('admin.destroy', $tutor->id) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this tutor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <form action="{{ route('admin.updatestatus', $tutor->id) }}" method="POST" class="inline-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $tutor->status === 'active' ? 'btn-warning' : 'btn-success' }}">
                                    {{ $tutor->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
