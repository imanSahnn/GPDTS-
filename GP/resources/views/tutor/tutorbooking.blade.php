<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Homepage</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
    <style>
        /* Additional CSS styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .table th, .table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
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
            cursor: pointer;
        }
    </style>
</head>
<body>
    @extends('tutor.layout')

    @section('title', 'Homepage')

    @section('content')
    <div class="container">
        <h1 class="text-3xl font-semibold mb-4">Student Bookings</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($bookings->isEmpty())
            <p>No bookings found.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>
                                <a href="#" onclick="showStudentDetail({{ $booking->student->id }}, '{{ $booking->student->name }}', '{{ $booking->student->number }}', '{{ $booking->student->email }}', '{{ asset('storage/' . $booking->student->picture) }}')">{{ $booking->student->name }}</a>
                            </td>
                            <td>{{ $booking->date }}</td>
                            <td>{{ $booking->time }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                <form action="{{ route('tutor.changeStatus', $booking->id) }}" method="POST">
                                    @csrf
                                    <select name="status" class="form-control" required>
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                    </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary mt-2">Update Status</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Student Detail Modal -->
    <div id="studentDetailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Student Details</h2>
            <div id="studentDetails">
                <!-- Student details will be populated here -->
            </div>
        </div>
    </div>

    <script>
        function showStudentDetail(id, name, number, email, picture) {
            var details = `
                <p><strong>Name:</strong> ${name}</p>
                <p><strong>Number:</strong> ${number}</p>
                <p><strong>Email:</strong> ${email}</p>
                <img src="${picture}" alt="${name}" class="w-32 h-32 rounded-full mx-auto mb-4">
            `;
            document.getElementById('studentDetails').innerHTML = details;
            document.getElementById('studentDetailModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('studentDetailModal').style.display = "none";
        }
    </script>
    @endsection
</body>
</html>
