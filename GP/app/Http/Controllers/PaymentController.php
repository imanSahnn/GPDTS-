<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use App\Models\FinalAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $student = Auth::guard('student')->user();
        $profilePicture = Student::where('id', $student->id)->value('picture');
        $courses = $student->courses()->distinct()->with('payments')->get();
        return view('student.payment', compact('courses', 'student', 'profilePicture'));
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
            'current_total' => null,
            'total_course_price' => $course->price,
            'payment_proof' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Payment submitted successfully. Awaiting approval.');
    }

    public function showConfirmPayment()
    {
        $payments = Payment::with(['student', 'course'])
        ->where(function ($query) {
            $query->where('payment_type', '!=', 'penalty')
                  ->orWhereNull('payment_type');
        })
        ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
        ->get();

        $penaltyPayments = Payment::with(['student', 'course'])
            ->where('payment_type', 'penalty')
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->get();

        return view('admin.confirmpayment', compact('payments', 'penaltyPayments'));
    }

    public function approvePayment($id)
    {
        $payment = Payment::findOrFail($id);
        $student = $payment->student;
        $course = $payment->course;

        $currentTotal = $student->payments()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->where('payment_type', '!=', 'penalty')
            ->sum('total_payment') + $payment->total_payment;

        $payment->update([
            'status' => 'approved',
            'current_total' => $currentTotal
        ]);

        $pdf = Pdf::loadView('admin.invoice', compact('payment'));

        $filePath = 'invoices/' . $payment->id . '_invoice.pdf';
        Storage::disk('public')->put($filePath, $pdf->output());

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

    public function submitPenaltyPayment(Request $request)
    {
        $request->validate([
            'final_assessment_id' => 'required|exists:finals,id',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'total_amount' => 'required|numeric',
        ]);

        $finalAssessment = FinalAssessment::findOrFail($request->final_assessment_id);

        $penaltyPayment = new Payment();
        $penaltyPayment->student_id = Auth::guard('student')->id();
        $penaltyPayment->course_id = $finalAssessment->course_id;
        $penaltyPayment->total_payment = $request->total_amount;
        $penaltyPayment->payment_type = 'penalty';
        $penaltyPayment->status = 'pending';

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('penalty_payments');
            $penaltyPayment->payment_proof = $proofPath;
        }

        $penaltyPayment->save();

        return redirect()->back()->with('success', 'Penalty payment submitted successfully.');
    }

    public function showPenaltyPayments()
    {
        $penaltyPayments = Payment::where('payment_type', 'penalty')->where('status', 'pending')->with('student', 'course')->get();
        return view('admin.penalty_payments', compact('penaltyPayments'));
    }

    public function approvePenaltyPayment($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 'approved';
        $payment->save();

        $finalAssessment = FinalAssessment::where('id', $payment->final_assessment_id)->first();
        if ($finalAssessment) {
            // Save the previous status of A and B
            $finalStatusA = $finalAssessment->final_statusA;
            $finalStatusB = $finalAssessment->final_statusB;
            $finalAssessment->delete();

            // Create a new final assessment entry with pending status and the same statuses of A and B
            $newFinalAssessment = new FinalAssessment();
            $newFinalAssessment->student_id = $payment->student_id;
            $newFinalAssessment->course_id = $payment->course_id;
            $newFinalAssessment->final_statusA = $finalStatusA;
            $newFinalAssessment->final_statusB = $finalStatusB;
            $newFinalAssessment->save();
        }

        return redirect()->back()->with('success', 'Penalty payment approved. The student can now book the final assessment again.');
    }
}
