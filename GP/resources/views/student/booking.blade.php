<!DOCTYPE html>
<html>
<head>
    <title>Book a Tutor</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@extends('layout.app')
@section('title', 'Book a Tutor')

@section('content')
<div>
    @include('student.sidebar')
</div>
<div>
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

    <div class="bg-blue pl-7 pr-7">
        <form action="{{ route('fetch_available_tutors') }}" method="POST" class="bg-white p-6 rounded shadow mb-4 ml-4">
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
    </div>
    <div class="mt-7 pl-7 pr-7">
        <h2 class="text-2xl font-bold text-center mb-4">Your Bookings</h2>

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
                            @if($booking->attendance_status == 'present')
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded" onclick="reviewBooking({{ $booking->id }}, '{{ $booking->tutor->name }}', '{{ asset('storage/' . $booking->tutor->picture) }}', '{{ $booking->date }}', '{{ $booking->time }}')">Review</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h2 class="text-lg leading-6 font-medium text-gray-900">Review Booking</h2>
                            <form id="reviewForm" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Tutor Name:</label>
                                    <p id="tutorName" class="text-gray-700"></p>
                                </div>
                                <div class="mb-4">
                                    <img id="tutorPicture" src="" alt="Tutor Picture" class="w-32 h-32 rounded-full mx-auto mb-4">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Date:</label>
                                    <p id="bookedDate" class="text-gray-700"></p>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-bold mb-2">Time:</label>
                                    <p id="bookedTime" class="text-gray-700"></p>
                                </div>
                                <div class="mb-4">
                                    <label for="rate" class="block text-gray-700 font-bold mb-2">Rate (1 to 5):</label>
                                    <input type="number" name="rate" id="rate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1" max="5" required>
                                </div>
                                <div class="mb-4">
                                    <label for="comment" class="block text-gray-700 font-bold mb-2">Comment:</label>
                                    <textarea name="comment" id="comment" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="closeModal('reviewModal')">Cancel</button>
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
                location.reload();
            }
        });
    }

    function closeModal(modalId) {
        $('#' + modalId).hide();
    }

    function reviewBooking(id, tutorName, tutorPicture, date, time) {
        $('#tutorName').text(tutorName);
        $('#tutorPicture').attr('src', tutorPicture);
        $('#bookedDate').text(date);
        $('#bookedTime').text(time);
        $('#reviewForm').attr('action', '{{ url("submit-review") }}/' + id);
        $('#reviewModal').show();
    }

    function closeModal(modalId) {
        $('#' + modalId).hide();
    }
</script>
</body>
</html>
