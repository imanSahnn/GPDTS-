<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Final Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(255, 0, 0, 0.71);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: rgb(255, 0, 0);
            text-decoration: none;
            cursor: pointer;
        }
        .modal-body {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .modal-body img {
            border-radius: 50%;
        }
        .modal-body div {
            flex-grow: 1;
        }
        .modal-body p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    @extends('admin.layout')

    @section('title', 'Final Bookings')

    @section('content')
        <div class="container">
            <h1 class="text-2xl font-bold leading-tight tracking-tight text-gray-900 md:text-3xl mb-6">
                Final Bookings
            </h1>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Status A</th>
                            <th>Status B</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($finalBookings as $booking)
                            <tr>
                                <td>{{ $booking->student->name }}</td>
                                <td>{{ $booking->final_date }}</td>
                                <td>{{ ucfirst($booking->final_statusA) }}</td>
                                <td>{{ ucfirst($booking->final_statusB) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="showModal({{ $booking->id }})">View</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($finalBookings as $booking)
            <div id="modal-{{ $booking->id }}" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal({{ $booking->id }})">&times;</span>
                    <h2 class="text-lg leading-6 font-medium text-gray-900">Final Booking Details</h2>
                    <div class="modal-body mt-5">
                            <img src="{{ asset('storage/' . $booking->student->picture) }}" alt="Profile Picture" class="rounded-full w-32 h-32 mx-auto mb-4">
                        <div>
                            <p><strong>Name:</strong> {{ $booking->student->name }}</p>
                            <p><strong>Course:</strong> {{ $booking->course->name }}</p>
                            <p><strong>Date:</strong> {{ $booking->final_date }}</p>

                            @if ($booking->proofA)
                                <p><strong>Proof A:</strong> <a href="{{ asset('storage/' . $booking->proofA) }}" target="_blank">View Proof A</a></p>
                            @endif

                            @if ($booking->proofB)
                                <p><strong>Proof B:</strong> <a href="{{ asset('storage/' . $booking->proofB) }}" target="_blank">View Proof B</a></p>
                            @endif
                        </div>
                    </div>

                    @php
                        $disableUpload = $booking->proofA && $booking->proofB;
                        $disableUpdate = $booking->final_statusA !== 'pending' && $booking->final_statusB !== 'pending';
                    @endphp

                    <form action="{{ route('admin.uploadFinalFiles', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="proofA" class="block text-gray-700 font-bold mb-2">Upload Proof A:</label>
                            <input type="file" name="proofA" id="proofA" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ $disableUpload ? 'disabled' : '' }} required>
                        </div>
                        <div class="mb-4">
                            <label for="proofB" class="block text-gray-700 font-bold mb-2">Upload Proof B:</label>
                            <input type="file" name="proofB" id="proofB" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ $disableUpload ? 'disabled' : '' }} required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" {{ $disableUpload ? 'disabled' : '' }}>Upload Files</button>
                    </form>

                    <form action="{{ route('admin.updateStatus', $booking->id) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-4">
                            <label for="final_statusA" class="block text-gray-700 font-bold mb-2">Update Status A:</label>
                            <select name="final_statusA" id="final_statusA" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="pending" {{ $booking->final_statusA == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="passed" {{ $booking->final_statusA == 'passed' ? 'selected' : '' }}>Passed</option>
                                <option value="failed" {{ $booking->final_statusA == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="final_statusB" class="block text-gray-700 font-bold mb-2">Update Status B:</label>
                            <select name="final_statusB" id="final_statusB" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                <option value="pending" {{ $booking->final_statusB == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="passed" {{ $booking->final_statusB == 'passed' ? 'selected' : '' }}>Passed</option>
                                <option value="failed" {{ $booking->final_statusB == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" {{ $disableUpdate ? 'disabled' : '' }}>Update Status</button>
                    </form>
                </div>
            </div>
        @endforeach

        <script>
            function showModal(id) {
                document.getElementById('modal-' + id).style.display = 'block';
            }

            function closeModal(id) {
                document.getElementById('modal-' + id).style.display = 'none';
            }
        </script>
    @endsection
</body>
</html>
