<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $student = Auth::guard('student')->user();
        $courses = $student->courses()->distinct()->with('payments')->get();
        return view('student.payment', compact('courses', 'student'));
    }

    public function submitPayment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course,id', // Correct the table name to match your database schema
            'total_payment' => 'required|numeric',
            'payment_proof' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048', // Include PDF in the validation
        ]);

        $student = Auth::guard('student')->user();
        $course = Course::findOrFail($request->course_id);

        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // Create a new payment record
        Payment::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'name' => $student->name,
            'ic' => $student->ic,
            'total_payment' => $request->total_payment,
            'payment_proof' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Payment submitted successfully. Awaiting approval.');
    }

    public function showConfirmPayment()
    {
        $payments = Payment::with(['student', 'course'])
        ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
        ->get();
        return view('admin.confirmpayment', compact('payments'));
    }

    public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'approved';
        $payment->save();

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    public function rejectPayment($id)
{
    $payment = Payment::findOrFail($id);
    $payment->status = 'rejected';
    $payment->save();

    return redirect()->back()->with('success', 'Payment rejected successfully.');
}
}
