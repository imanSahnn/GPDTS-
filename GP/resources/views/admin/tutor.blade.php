@extends('admin.layout')

@section('title', 'Tutors')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-[#004225]">Available Tutors</h1>

    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead class="bg-[#FFCF9D] text-[#004225]">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Picture</th>
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">IC</th>
                    <th class="py-2 px-4 text-left">Phone Number</th>
                    <th class="py-2 px-4 text-left">Course</th>
                    <th class="py-2 px-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tutors as $tutor)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="py-2 px-4">{{ $tutor->id }}</td>
                        <td class="py-2 px-4">
                            @if($tutor->picture)
                                <img src="{{ asset('storage/' . $tutor->picture) }}" alt="Profile Picture" class="w-12 h-12 rounded-full mx-auto">
                            @else
                                No Picture
                            @endif
                        </td>
                        <td class="py-2 px-4">{{ $tutor->name }}</td>
                        <td class="py-2 px-4">{{ $tutor->email }}</td>
                        <td class="py-2 px-4">{{ $tutor->ic }}</td>
                        <td class="py-2 px-4">{{ $tutor->number }}</td>
                        <td class="py-2 px-4">{{ $tutor->course->name }}</td>
                        <td class="py-2 px-4 text-center flex justify-center space-x-2">
                            <a href="{{ route('admin.viewtutor', [$tutor->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">View</a>
                            <a href="{{ route('admin.edittutor', [$tutor->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                            <form action="{{ route('admin.destroy', $tutor->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this tutor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                            </form>
                            <form action="{{ route('admin.updatestatus', $tutor->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="font-bold py-1 px-2 rounded {{ $tutor->status === 'active' ? 'bg-orange-500 hover:bg-orange-700 text-white' : 'bg-green-500 hover:bg-green-700 text-white' }}">
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
