@extends('admin.layout')

@section('title', 'View Student')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl mb-6">
        View Student
    </h1>

    <div class="bg-white shadow-md rounded-lg p-6 space-y-6">
        <div class="flex items-center justify-center">
            @if ($student->picture)
                <img src="{{ asset('storage/' . $student->picture) }}" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover">
            @else
                <p class="text-gray-500">No picture available</p>
            @endif
        </div>
        <div class="bg-gray-50 border border-gray-300 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                    <p id="name" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                        {{ $student->name }}
                    </p>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <p id="email" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                        {{ $student->email }}
                    </p>
                </div>
                <div>
                    <label for="ic" class="block mb-2 text-sm font-medium text-gray-700">IC</label>
                    <p id="ic" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                        {{ $student->ic }}
                    </p>
                </div>
                <div>
                    <label for="number" class="block mb-2 text-sm font-medium text-gray-700">Phone Number</label>
                    <p id="number" class="bg-white border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5">
                        {{ $student->number }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
            <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl mb-4">
                Courses
            </h2>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Course</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">First Payment Date</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($uniqueCourses as $course)
                        @php
                           $firstPaymentDate = \Carbon\Carbon::parse($course->firstPaymentDate);
                            $isDeactivatable = $firstPaymentDate->lt(\Carbon\Carbon::now()->subYears(2));
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ $course->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">{{ $course->firstPaymentDate ? $course->firstPaymentDate->format('Y-m-d') : 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                <form action="{{ route('admin.deactivate-course', ['studentId' => $student->id, 'courseId' => $course->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to deactivate and delete all related data for this course?')">Deactivate</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

