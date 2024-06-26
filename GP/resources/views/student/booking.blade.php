<!DOCTYPE html>
<html>
<head>
    <title>Book a Tutor</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        /* Your custom styles here */
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .ui-datepicker {
            background: #ffffff;
            border: 1px solid #aaa;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .ui-datepicker-header {
            background: #164863;
            color: #ffffff;
            border-bottom: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px 8px 0 0;
        }

        .ui-datepicker-title {
            font-weight: bold;
        }

        .ui-state-default {
            border: 1px solid #ddd;
            background: #f9f9f9;
            color: #333;
            border-radius: 4px;
            padding: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .ui-state-hover,
        .ui-state-active {
            background: #164863;
            color: #ffffff;
        }

        .ui-datepicker-calendar td a {
            text-align: center;
            display: block;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px; /* Limit the maximum width */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: grab;
        }

        .conten-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding-top: 60px; /* Increase the top padding */
            padding-bottom: 60px; /* Increase the bottom padding */
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(152, 22, 22, 0.2);
            width: 90%; /* Set a wider width */
            min-width: 320px; /* Limit the minimum width */
            margin: auto; /* Center the box horizontally */
        }

        .tutor-card {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .tutor-card img {
            border-radius: 50%;
            margin-right: 10px;
            width: 50px;
            height: 50px;
        }

        .final-box {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        /* Responsive classes */
        @media (min-width: 640px) {
            .conten-box {
                width: 80%; /* Adjust width for medium screens */
            }
        }

        @media (min-width: 768px) {
            .conten-box {
                width: 70%; /* Adjust width for large screens */
            }
        }

        @media (min-width: 1024px) {
            .conten-box {
                width: 60%; /* Adjust width for extra-large screens */
            }
        }
    </style>
</head>
<body>
    @extends('layout.app')
    @section('title', 'Book a Tutor')

    @section('content')
    <div>
        @include('student.sidebar')
    </div>
    <div class="conten-box">
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
            <h2 class="text-2xl font-bold text-center mb-4">Fill in the Details</h2>
            <form action="{{ route('fetch_available_tutors') }}" method="POST" class="bg-white p-6 rounded shadow mb-4 ml-4">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="course" class="block text-gray-700 font-bold mb-2">Course</label>
                        <select id="course" name="course_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">Select a Course</option>
                            @foreach($chosenCourses as $course)
                                @if($coursePaymentStatus[$course->id])
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @else
                                    <option value="{{ $course->id }}" disabled>{{ $course->name }} (Minimum 15% payment required)</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="date" class="block text-gray-700 font-bold mb-2">Date:</label>
                        <input value="Choose a Date" type="text" id="date" name="date" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                    </div>
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <label for="time" class="block text-gray-700 font-bold mb-2">Time:</label>
                        <select name="time" id="time" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                            <option value="">Select a Time</option>
                            <option value="08:30">08:30 AM - 10:00 AM</option>
                            <option value="10:00">10:00 AM - 11:30 AM</option>
                            <option value="11:30">11:30 AM - 01:00 PM</option>
                            <option value="14:00">02:00 PM - 03:30 PM</option>
                            <option value="15:30">03:30 PM - 05:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Search</button>
                </div>
            </form>
        </div>

        @if(session('availableTutors'))
        <div class="mt-7 pl-7 pr-7 ">
            <h2 class="text-2xl font-bold text-center mb-4">Available Tutors</h2>
            <div class="overflow-x-auto ">
                <table id="tutorsTable" class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200">Picture</th>
                            <th class="py-2 px-4 border-b border-gray-200">Tutor Name</th>
                            <th class="py-2 px-4 border-b border-gray-200">Course</th>
                            <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('availableTutors') as $tutor)
                            <tr class="text-center">
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <img src="{{ asset('storage/' . $tutor->picture) }}" alt="Tutor Picture" class="rounded-full w-12 h-12 mx-auto">
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $tutor->course->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <form action="{{ route('book_class') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                                        <input type="hidden" name="course_id" value="{{ $tutor->course_id }}">
                                        <input type="hidden" name="date" value="{{ session('date') }}">
                                        <input type="hidden" name="time" value="{{ session('time') }}">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Book</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="mt-7 pl-7 pr-7">
            <h2 class="text-2xl font-bold text-center mb-4">Your Bookings</h2>

            <!-- Sorting Options -->
            <div class="flex justify-end mb-4">
                <label for="sort" class="block text-gray-700 font-bold mr-2">Sort By:</label>
                <select id="sort" class="block appearance-none bg-gray-200 border border-gray-200 text-gray-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" onchange="sortTable()">
                    <option value="name">Name</option>
                    <option value="date">Date</option>
                    <option value="time">Time</option>
                    <option value="status">Status</option>
                </select>
            </div>

            <div class="bg-white p-6 rounded shadow mb-4 ml-4">
                <table id="bookingsTable" class="min-w-full bg-white">
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
                            <tr class="text-center status-{{ strtolower($booking->status) }}">
                                <td class="py-2 px-4 border-b border-gray-200">{{ $booking->tutor->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $booking->date }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $booking->time }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ ucfirst($booking->status) }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    @if(\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($booking->date)) && $booking->status !== 'rejected')
                                        <button type="button" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded" onclick="editBooking({{ $booking->id }}, '{{ $booking->date }}', '{{ $booking->time }}')">Edit</button>
                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="confirmDelete({{ $booking->id }})">Delete</button>
                                    @endif
                                    @if($booking->attendance_status == 'present')
                                        <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded" onclick="reviewBooking({{ $booking->id }}, '{{ $booking->tutor->name }}', '{{ asset('storage/' . $booking->tutor->picture) }}', '{{ $booking->date }}', '{{ $booking->time }}')">Review</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

<!-- Final Assessment Section -->
@if($finalAssessment)
    <div class="bg-blue-100 p-6 rounded shadow mb-4">
        <h2 class="text-2xl font-bold text-center mb-4">Your Final Assessment Booking</h2>
        <div class="bg-white p-6 rounded shadow mb-4">
            <div class="mb-4">
                <label for="course_name" class="block text-gray-700 font-bold mb-2">Course:</label>
                <input type="text" id="course_name" name="course_name" value="{{ $finalAssessment->course->name }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
            </div>
            <div class="mb-4">
                <label for="final_date" class="block text-gray-700 font-bold mb-2">Date:</label>
                <input type="text" id="final_date" name="final_date" value="{{ $finalAssessment->final_date }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
            </div>
            <div id="final-upload-section">
                <form action="{{ route('submit_final_assessment') }}" method="POST" class="bg-white p-6 rounded shadow mb-4" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="course_id" id="upload_course_id" value="{{ $finalAssessment->course_id }}">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold mb-2">Section A</h3>
                        <label for="final_statusA" class="block text-gray-700 font-bold mb-2">Status:</label>
                        <input type="text" id="final_statusA" name="final_statusA" value="{{ ucfirst($finalAssessment->final_statusA) }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-bold mb-2">Section B</h3>
                        <label for="final_statusB" class="block text-gray-700 font-bold mb-2">Status:</label>
                        <input type="text" id="final_statusB" name="final_statusB" value="{{ ucfirst($finalAssessment->final_statusB) }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="bg-blue-100 p-6 rounded shadow mb-4">
        <h2 class="text-2xl font-bold text-center mb-4">Schedule Your Final Assessment</h2>
        <form id="final-assessment-form" class="bg-white p-6 rounded shadow mb-4">
            @csrf
            <div class="mb-4">
                <label for="course_id" class="block text-gray-700 font-bold mb-2">Select a Course:</label>
                <select id="course_id" name="course_id" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                    <option value="">Select a Course</option>
                    @php
                        $uniqueCourses = $eligibleCourses->unique('id');
                    @endphp
                    @foreach($uniqueCourses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="final_date" class="block text-gray-700 font-bold mb-2">Choose a Date:</label>
                <input type="text" id="final_date" name="final_date" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                <button type="button" id="book-final-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-2">Book</button>
            </div>
        </form>

        <div id="final-upload-section" style="display: none;">
            <form action="{{ route('submit_final_assessment') }}" method="POST" class="bg-white p-6 rounded shadow mb-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" id="upload_course_id">
                <div class="mb-4">
                    <h3 class="text-lg font-bold mb-2">Section A</h3>
                    <label for="final_statusA" class="block text-gray-700 font-bold mb-2">Status:</label>
                    <input type="text" id="final_statusA" name="final_statusA" value="Pending" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-bold mb-2">Section B</h3>
                    <label for="final_statusB" class="block text-gray-700 font-bold mb-2">Status:</label>
                    <input type="text" id="final_statusB" name="final_statusB" value="Pending" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                </div>
            </form>
        </div>
    </div>
@endif



    <!-- Edit Booking Modal -->
    <div id="editBookingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editBookingModal')">&times;</span>
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

    <!-- Delete Booking Modal -->
    <div id="deleteBookingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteBookingModal')">&times;</span>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h2>
            <p class="text-gray-700 mt-2">Are you sure you want to delete this booking?</p>
            <form id="deleteBookingForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <input type="hidden" id="deleteBookingId" name="id" value="">
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Delete</button>
                    <button type="button" class="mt-3 sm:mt-0 sm:ml-3 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onclick="closeModal('deleteBookingModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('reviewModal')">&times;</span>
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

    <!-- Penalty Payment Section -->
    @if(isset($penaltyPayment) && $penaltyPayment->status === 'pending')
        <div class="bg-red-100 p-6 rounded shadow mb-4">
            <h2 class="text-2xl font-bold text-center mb-4">Penalty Payment Required</h2>
            <div class="bg-white p-6 rounded shadow mb-4 flex">
                <div class="w-1/2">
                    <h3 class="text-lg font-bold mb-2">Bank Details:</h3>
                    <p>Bank Name: XYZ Bank</p>
                    <p>Account Number: 1234567890</p>
                    <p>Account Holder: ABC Company</p>
                    <img src="{{ asset('images/bank-details.jpg') }}" alt="Bank Details" class="w-full h-auto mt-4">
                </div>
                <div class="w-1/2 pl-4">
                    <form action="{{ route('submit_penalty_payment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="final_assessment_id" value="{{ $penaltyPayment->final_assessment_id }}">
                        <input type="hidden" name="total_amount" value="{{ $penaltyPayment->amount }}">
                        <div class="mb-4">
                            <label for="student_name" class="block text-gray-700 font-bold mb-2">Student Name:</label>
                            <input type="text" id="student_name" name="student_name" value="{{ $user->name }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="course_name" class="block text-gray-700 font-bold mb-2">Course:</label>
                            <input type="text" id="course_name" name="course_name" value="{{ $penaltyPayment->course->name }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="total_amount" class="block text-gray-700 font-bold mb-2">Total Amount:</label>
                            <input type="text" id="total_amount" name="total_amount" value="{{ $penaltyPayment->amount }}" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="proof" class="block text-gray-700 font-bold mb-2">Upload Payment Proof:</label>
                            <input type="file" id="proof" name="proof" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(function() {
    $("#date, #edit_date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 3, // 72 hours minimum
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0), '']; // Disable Sundays
        }
    });

    $("#final_date").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 3, // 72 hours minimum
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [day === 0, '']; // Enable only Sundays
        }
    });

    $('#book-final-button').on('click', function() {
        let selectedDate = $('#final_date').datepicker('getDate');
        if (selectedDate) {
            $.ajax({
                url: '{{ route("schedule_final") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    course_id: $('#course_id').val(),
                    final_date: $('#final_date').val(),
                    final_statusA: 'pending',
                    final_statusB: 'pending'
                },
                success: function(response) {
                    if (response.success) {
                        $('#book-final-button').hide();
                        $('#final_date').prop('disabled', true);
                        $('#upload_course_id').val($('#course_id').val());
                        $('#final-upload-section').show();
                        alert('Final assessment booked successfully.');
                    } else {
                        alert('An error occurred while booking the final assessment: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = xhr.status + ': ' + xhr.statusText;
                    alert('Error - ' + errorMessage);
                }
            });
        }
    });

    function checkFinalUploadAvailability() {
        let currentDate = new Date();
        let bookingDate = new Date($('#final_date').datepicker('getDate'));
        bookingDate.setHours(9, 0, 0, 0); // Set booking date to 9 AM

        if (currentDate >= bookingDate) {
            $('#proofA').prop('disabled', false);
            $('#proofB').prop('disabled', false);
        } else {
            $('#proofA').prop('disabled', true);
            $('#proofB').prop('disabled', true);
        }
    }

    setInterval(checkFinalUploadAvailability, 60000); // Check every minute

    // Ensure the upload section is properly enabled/disabled on page load
    checkFinalUploadAvailability();
});

function editBooking(id, date, time) {
    $('#edit_date').val(date);
    $('#edit_time').val(time);
    $('#editBookingForm').attr('action', '{{ url("edit-booking") }}/' + id);
    $('#editBookingModal').show();
}

function confirmDelete(id) {
    $('#deleteBookingId').val(id);
    $('#deleteBookingForm').attr('action', '{{ url("delete-booking") }}/' + id);
    $('#deleteBookingModal').show();
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

function sortTable() {
    var table, rows, switching, i, x, y, shouldSwitch, sortOption, sortOrder;
    table = document.getElementById("bookingsTable");
    switching = true;
    sortOption = document.getElementById("sort").value;
    sortOrder = sortOption === "date" || sortOption === "time" ? "asc" : "desc";

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[sortOption === "name" ? 0 : sortOption === "date" ? 1 : sortOption === "time" ? 2 : 3];
            y = rows[i + 1].getElementsByTagName("TD")[sortOption === "name" ? 0 : sortOption === "date" ? 1 : sortOption === "time" ? 2 : 3];
            if (sortOrder === "asc" ? x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase() : x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

function showPenaltyPaymentModal() {
    $('#penaltyPaymentModal').show();
}
</script>
</body>
</html>


