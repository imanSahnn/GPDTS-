<!DOCTYPE html>
<html>
<head>
    <title>Book a Tutor</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@extends('student.layout')

@section('title', 'Book a Tutor')

@section('content')
<div class="container mx-auto mt-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="col-span-1">
            @include('student.sidebar')
        </div>
        <div class="col-span-3">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('fetch_available_tutors') }}" method="POST" class="bg-white p-6 rounded shadow mb-4">
                @csrf
                <div class="mb-4">
                    <label for="course" class="block text-gray-700 font-bold mb-2">Course</label>
                    <select id="course" name="course_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">Select a Course</option>
                        @foreach($chosenCourses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="date" class="block text-gray-700 font-bold mb-2">Choose a Date:</label>
                    <input type="text" id="date" name="date" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                </div>
                <div class="mb-4">
                    <label for="time" class="block text-gray-700 font-bold mb-2">Choose a Time:</label>
                    <select name="time" id="time" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        <option value="">Select a Time</option>
                        <option value="08:30">08:30 AM - 10:00 AM</option>
                        <option value="10:00">10:00 AM - 11:30 AM</option>
                        <option value="11:30">11:30 AM - 01:00 PM</option>
                        <option value="14:00">02:00 PM - 03:30 PM</option>
                        <option value="15:30">03:30 PM - 05:00 PM</option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Search</button>
                </div>
            </form>

            @if(isset($availableTutors))
                <h2 class="text-2xl font-bold text-center mb-4">Available Tutors</h2>
                <form action="{{ route('create_booking') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ request('course_id') }}">
                    <input type="hidden" name="date" value="{{ request('date') }}">
                    <input type="hidden" name="time" value="{{ request('time') }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($availableTutors as $tutor)
                            <div class="bg-white p-6 rounded shadow">
                                <h5 class="text-xl font-bold mb-2">{{ $tutor->name }}</h5>
                                <p class="text-gray-700 mb-4">Expertise: {{ $tutor->expertise }}</p>
                                <button type="submit" name="tutor_id" value="{{ $tutor->id }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Choose</button>
                            </div>
                        @endforeach
                    </div>
                </form>
            @endif

            <h2 class="text-2xl font-bold text-center mt-5 mb-4">Your Bookings</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">Tutor Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200">Time</th>
                            <th class="py-2 px-4 border-b border-gray-200">Status</th>
                            <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="status-{{ strtolower($booking->status) }}">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $booking->tutor->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $booking->date }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $booking->time }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ ucfirst($booking->status) }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($booking->date)))
                                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded" onclick="editBooking({{ $booking->id }}, '{{ $booking->date }}', '{{ $booking->time }}')">Edit</button>
                                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="confirmDelete({{ $booking->id }})">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Edit Booking Modal -->
            <div id="editBookingModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">Edit Booking</h2>
                                    <form id="editBookingForm" method="POST" class="mt-5">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="edit_date" class="block text-gray-700 font-bold mb-2">Choose a Date:</label>
                                            <input type="text" id="edit_date" name="date" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="edit_time" class="block text-gray-700 font-bold mb-2">Choose a Time:</label>
                                            <select name="time" id="edit_time" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                                                <option value="">Select a Time</option>
                                                <option value="08:30">08:30 AM - 10:00 AM</option>
                                                <option value="10:00">10:00 AM - 11:30 AM</option>
                                                <option value="11:30">11:30 AM - 01:00 PM</option>
                                                <option value="14:00">02:00 PM - 03:30 PM</option>
                                                <option value="15:30">03:30 PM - 05:00 PM</option>
                                            </select>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="closeModal('editBookingModal')">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Booking Modal -->
            <div id="deleteBookingModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                    <h2 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h2>
                                    <p class="text-gray-700 mt-2">Are you sure you want to delete this booking?</p>
                                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                        <button id="confirmDeleteBtn" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Delete</button>
                                        <button type="button" class="mt-3 sm:mt-0 sm:ml-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="closeModal('deleteBookingModal')">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(function() {
        // Initialize datepicker
        $("#date, #edit_date").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 1,
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0), '']; // Disable Sundays
            }
        });
    });

    function editBooking(id, date, time) {
        $('#edit_date').val(date);
        $('#edit_time').val(time);
        $('#editBookingForm').attr('action', '{{ url("edit-booking") }}/' + id);
        $('#editBookingModal').show();
    }

    function confirmDelete(id) {
        $('#confirmDeleteBtn').attr('onclick', 'deleteBooking(' + id + ')');
        $('#deleteBookingModal').show();
    }

    function deleteBooking(id) {
        $.ajax({
            url: '/delete-booking/' + id,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                // Reload the page after successful deletion
                location.reload();
            }
        });
    }

    function closeModal(modalId) {
        $('#' + modalId).hide();
    }
</script>
</body>
</html>
