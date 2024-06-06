@extends('admin.layout')

@section('title', 'Tutors')

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Approved Tutors</h1>
        <a href="{{ route('admin.createtutor') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Tutor</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200">Name</th>
                    <th class="py-2 px-4 border-b border-gray-200">Email</th>
                    <th class="py-2 px-4 border-b border-gray-200">IC</th>
                    <th class="py-2 px-4 border-b border-gray-200">Phone Number</th>
                    <th class="py-2 px-4 border-b border-gray-200">Course</th>
                    <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tutors as $tutor)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->ic }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->number }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->course->name }}</td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            <a href="{{ route('admin.edittutor', [$tutor->id]) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('admin.destroy', $tutor->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this tutor?');">
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
