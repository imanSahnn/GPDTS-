@extends('admin.layout')

@section('title', 'Confirm Payments')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Confirm Payments</h1>

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

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Student Name</th>
                    <th class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Course</th>
                    <th class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Payment</th>
                    <th class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Payment Proof</th>
                    <th class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $payment)
                <tr class="{{ $payment->status === 'pending' ? 'bg-yellow-100' : ($payment->status === 'approved' ? 'bg-green-100' : 'bg-red-100') }}">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payment->student->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $payment->course->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ $payment->total_payment }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" target="_blank" class="text-blue-500 hover:text-blue-700">View Proof</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($payment->status === 'pending')
                            <form action="{{ route('admin.approve_payment', $payment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Approve</button>
                            </form>
                            <form action="{{ route('admin.reject_payment', $payment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Reject</button>
                            </form>
                        @else
                            <span class="text-gray-500">{{ ucfirst($payment->status) }}</span>
                        @endif
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDetails(id) {
        const detailsRow = document.getElementById(`details-${id}`);
        if (detailsRow.style.display === 'none') {
            detailsRow.style.display = 'table-row';
        } else {
            detailsRow.style.display = 'none';
        }
    }
</script>
@endsection
