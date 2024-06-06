@extends('admin.layout')

@section('title', 'Pending Tutors')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Pending Tutors</h1>
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b border-gray-200">Name</th>
                <th class="py-2 px-4 border-b border-gray-200">Email</th>
                <th class="py-2 px-4 border-b border-gray-200">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingTutors as $tutor)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->email }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <form action="{{ route('admin.approveTutor', $tutor->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
                        </form>
                        <form action="{{ route('admin.rejectTutor', $tutor->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
