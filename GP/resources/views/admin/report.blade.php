@extends('admin.layout')


@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Generate Report</h2>
    <form action="{{ route('admin.reportresult') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="report_type" class="block text-gray-700 font-bold mb-2">Select Report Type:</label>
            <select id="report_type" name="report_type" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                <option value="">Select a Report Type</option>
                <option value="bookings">Bookings</option>
                <option value="payments">Payments</option>
                <option value="final_assessments">Final Assessments</option>
                <option value="ratings">Ratings</option>
                <option value="students">Students</option>
                <option value="tutors">Tutors</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="filter_by" class="block text-gray-700 font-bold mb-2">Filter By:</label>
            <select id="filter_by" name="filter_by" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option value="">None</option>
                <option value="course_name">Course Name</option>
                <option value="student_name">Student Name</option>
                <option value="tutor_name">Tutor Name</option>
                <option value="status">Status</option>
            </select>
            <input type="text" id="filter_value" name="filter_value" class="mt-2 block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="Filter Value">
        </div>

        <div class="mb-4">
            <label for="sort_by" class="block text-gray-700 font-bold mb-2">Sort By:</label>
            <select id="sort_by" name="sort_by" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                <option value="">None</option>
                <option value="date">Date</option>
                <option value="time">Time</option>
                <option value="status">Status</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Generate Report</button>
        </div>
    </form>
</div>
@endsection
