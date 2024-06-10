<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\InvoiceMail;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $student = Auth::guard('student')->user();
        $profilePicture = Student::where('id', $student->id)->value('picture');
        $courses = $student->courses()->distinct()->with('payments')->get();
        return view('student.payment', compact('courses', 'student','profilePicture'));


    }

    public function submitPayment(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course,id',
            'total_payment' => 'required|numeric',
            'payment_proof' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ]);

        $student = Auth::guard('student')->user();
        $course = Course::findOrFail($request->course_id);

        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        Payment::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'name' => $student->name,
            'ic' => $student->ic,
            'total_payment' => $request->total_payment,
            'current_total' => null,  // Do not set current_total here
            'total_course_price' => $course->price,
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
        $student = $payment->student;
        $course = $payment->course;

        // Calculate the current total after approval
        $currentTotal = $student->payments()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->sum('total_payment') + $payment->total_payment;

        // Update payment status to approved and set current_total
        $payment->update([
            'status' => 'approved',
            'current_total' => $currentTotal
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('admin.invoice', compact('payment'));

        // Save PDF to storage
        $filePath = 'invoices/' . $payment->id . '_invoice.pdf';
        Storage::disk('public')->put($filePath, $pdf->output());

        // Update payment with the invoice path
        $payment->update(['invoice' => $filePath]);

        return redirect()->back()->with('success', 'Payment approved successfully and invoice saved.');
    }

    public function rejectPayment($id)
{
    $payment = Payment::findOrFail($id);
    $payment->status = 'rejected';
    $payment->save();

    return redirect()->back()->with('success', 'Payment rejected successfully.');
}
}
