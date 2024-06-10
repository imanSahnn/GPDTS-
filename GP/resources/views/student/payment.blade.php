@extends('layout.app')

@section('title', 'Payment')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Payment</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Course Selection Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Course Selection</h2>
            <form id="courseSelectionForm">
                <label for="course_id" class="block text-gray-700 text-sm font-bold mb-2">Choose Course:</label>
                <select name="course_id" id="course_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Select a Course</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" data-price="{{ $course->price }}" data-paid="{{ $course->payments->where('status', 'approved')->sum('total_payment') }}">{{ $course->name }}</option>
                    @endforeach
                </select>
                <div class="mt-4">
                    <p class="text-lg"><strong>Total Course Price: </strong><span id="totalCoursePrice">-</span></p>
                    <p class="text-lg"><strong>Total Paid: </strong><span id="totalPaid">-</span></p>
                </div>
            </form>
        </div>

        <!-- Payment Form Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Payment Form</h2>
            <form action="{{ route('submit_payment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="course_id" id="selectedCourseId">
                <input type="hidden" name="current_total" id="current_total"> <!-- Hidden input for current total -->
                <input type="hidden" id="coursePrice"> <!-- Hidden input for course price -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $student->name }}" readonly>
                </div>
                <div class="mb-4">
                    <label for="ic" class="block text-gray-700 text-sm font-bold mb-2">IC Number:</label>
                    <input type="text" name="ic" id="ic" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $student->ic }}" readonly>
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="total_payment" class="block text-gray-700 text-sm font-bold mb-2">Total Payment:</label>
                    <input type="number" name="total_payment" id="total_payment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="payment_proof" class="block text-gray-700 text-sm font-bold mb-2">Upload Payment Proof:</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" accept=".jpeg,.png,.jpg,.gif,.pdf" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" id="submitPaymentBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Past Payments and Invoice Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg mt-8">
        <h2 class="text-2xl font-bold mb-4">Your Payments</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200">Course</th>
                        <th class="py-2 px-4 border-b border-gray-200">Total Payment</th>
                        <th class="py-2 px-4 border-b border-gray-200">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200">Invoice</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($student->payments as $payment)
                        <tr class="text-center">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $payment->course->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">${{ $payment->total_payment }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ ucfirst($payment->status) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                @if($payment->status == 'approved' && $payment->invoice)
                                    <a href="{{ asset('storage/' . $payment->invoice) }}" class="text-blue-500 hover:underline" download>Download Invoice</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('course_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const paid = selectedOption.getAttribute('data-paid');

            document.getElementById('totalCoursePrice').innerText = price ? `$${price}` : '-';
            document.getElementById('totalPaid').innerText = paid ? `$${paid}` : '-';

            document.getElementById('selectedCourseId').value = this.value;
            document.getElementById('coursePrice').value = price;

            toggleSubmitButton(price, paid);
        });

        function toggleSubmitButton(price, paid) {
            const submitButton = document.getElementById('submitPaymentBtn');
            if (price && paid && parseFloat(price) === parseFloat(paid)) {
                submitButton.style.display = 'none';
            } else {
                submitButton.style.display = 'block';
            }
        }
    </script>
</div>
@endsection
