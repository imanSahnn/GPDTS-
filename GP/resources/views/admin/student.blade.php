@extends('admin.layout')

@section('title', 'Student Page')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Student Page</h1>
        </div>

        <p class="mb-4">This is the content of the student page.</p>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-800 text-white text-center">
                        <th class="w-16 py-2 px-4">ID</th>
                        <th class="py-2 px-4">Profile Picture</th>
                        <th class="py-2 px-4">Name</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Phone Number</th>
                        <th class="py-2 px-4">Status</th>
                        <th class="py-2 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="{{ $student->deactivationRequired ? 'bg-red-100' : 'bg-white' }} border-b text-center">
                            <td class="py-2 px-4">{{ $student->id }}</td>
                            <td class="py-2 px-4">
                                @if($student->picture)
                                    <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="w-12 h-12 rounded-full mx-auto">
                                @else
                                    No Picture
                                @endif
                            </td>
                            <td class="py-2 px-4">{{ $student->name }}</td>
                            <td class="py-2 px-4">{{ $student->email }}</td>
                            <td class="py-2 px-4">{{ $student->number }}</td>
                            <td class="py-2 px-4">{{ ucfirst($student->status) }}</td>
                            <td class="py-2 px-4 flex justify-center space-x-2">
                                <a href="{{ route('admin.viewstudent', [$student->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">View</a>
                                <a href="{{ route('admin.editstudent', [$student->id]) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                                <form action="{{ route('admin.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                                </form>
                                <form action="{{ route('admin.toggleStatus', $student->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    @if($student->status == 'active')
                                        <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-1 px-2 rounded">Deactivate</button>
                                    @else
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Activate</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
