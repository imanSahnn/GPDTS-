@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <h2 class="text-3xl font-bold text-center mt-8">Approve Uploads</h2>

        <!-- Display students with pending approval -->
        @foreach($pendingStudents as $student)
            <div class="bg-white p-6 rounded-lg shadow-lg mb-4">
                <h3 class="text-2xl font-bold mb-2">{{ $student->name }}</h3>
                <p class="mb-2">Upload Date: {{ $student->lesen_picture_date }}</p>
                <img src="{{ Storage::url('lesen_picture/' . $student->lesen_picture) }}" alt="Lesen Picture" class="w-32 h-32 mb-4">
                <form action="{{ route('admin.approve', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label for="next_upload_due_date" class="block mb-2 font-bold">Next Upload Due Date:</label>
                    <select name="next_upload_due_date" class="shadow appearance-none border rounded w-full py-2 px-3 mb-4">
                        <option value="{{ \Carbon\Carbon::now()->addMonths(3)->format('Y-m-d') }}">3 Months from now</option>
                        <option value="{{ \Carbon\Carbon::now()->addMonths(6)->format('Y-m-d') }}">6 Months from now</option>
                    </select>
                    <button type="submit" name="action" value="approve" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Approve</button>
                    <button type="submit" name="action" value="reject" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                </form>
            </div>
        @endforeach

        <!-- Display students with due date today -->
        <h2 class="text-3xl font-bold text-center mt-8">Students with Due Date Today</h2>
        @if($dueTodayStudents->isEmpty())
            <p class="text-center">No students have due dates today.</p>
        @else
            @foreach($dueTodayStudents as $student)
                <div class="bg-red-100 p-6 rounded-lg shadow-lg mb-4">
                    <h3 class="text-2xl font-bold mb-2">{{ $student->name }}</h3>
                    <p class="mb-2">Next Upload Due Date: {{ $student->next_upload_due_date }}</p>
                    <p class="mb-2">Current Status: {{ $student->status }}</p>
                </div>
            @endforeach
        @endif
    </div>
@endsection
