<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\Payment;
use App\Models\Course;
use App\Models\FinalAssessment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $pendingStudents = Student::where('lesen_picture_status', 'pending')->get();
        $dueTodayStudents = Student::where('next_upload_due_date', Carbon::today()->toDateString())->get();
        return view('admin.homepage', compact('pendingStudents', 'dueTodayStudents'));
    }

    public function handleApproval(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        if ($request->input('action') == 'approve') {
            $student->lesen_picture_status = 'approved';
            $student->status = 'active';
            $student->next_upload_due_date = $request->input('next_upload_due_date');
        } else {
            // Remove the file
            if (Storage::exists('public/lesen_picture/' . $student->lesen_picture)) {
                Storage::delete('public/lesen_picture/' . $student->lesen_picture);
            }

            $student->lesen_picture_status = 'rejected';
            $student->status = 'inactive';
            $student->lesen_picture = null;
            $student->lesen_picture_date = null;
            $student->next_upload_due_date = null;
        }

        $student->save();

        return redirect()->route('admin.showApprovalForm')->with('status', 'Student status updated successfully.');
    }

    public function student()
    {
        $students = Student::with('courses')->get();

        foreach ($students as $student) {
            $student->deactivationRequired = false;
            foreach ($student->courses as $course) {
                $firstPayment = Payment::where('student_id', $student->id)
                    ->where('course_id', $course->id)
                    ->orderBy('created_at', 'asc')
                    ->first();

                if ($firstPayment) {
                    $firstPaymentDate = Carbon::parse($firstPayment->created_at);
                    if ($firstPaymentDate->lt(Carbon::now()->subYears(2))) {
                        $student->deactivationRequired = true;
                        break;
                    }
                }
            }
        }

        // Sort students by deactivationRequired flag
        $students = $students->sortByDesc(function ($student) {
            return $student->deactivationRequired;
        });

        return view('admin.student', compact('students'));
    }
    public function deactivateCourse($studentId, $courseId)
    {
        // Handle the deactivation logic
        $student = Student::findOrFail($studentId);

        // Delete payments related to the student and course
        Payment::where('student_id', $student->id)
            ->where('course_id', $courseId)
            ->delete();

        // Delete bookings related to the student and course
        Booking::where('student_id', $student->id)
            ->where('course_id', $courseId)
            ->delete();

        // Remove the course from the student's courses (without deleting the course itself)
        $student->courses()->detach($courseId);

        return redirect()->back()->with('success', 'Course deactivated and related data deleted successfully.');
    }
    public function view($id)
    {
        $student = Student::find($id);  // Corrected variable name
        return view('admin.viewstudent')->with('students', $student);
    }

    public function tutor()
    {
        $tutors = Tutor::where('approved', true)->get();
        return view('admin.tutor', compact('tutors'));
    }

    public function course()
    {
        $courses = Course::all();
        return view('admin.course', compact('courses'));
    }

    public function payment()
    {
        return view('admin.confirmpayment');
    }

    public function showFinalBookings()
    {
        $finalBookings = FinalAssessment::with('student', 'course')->get();
        return view('admin.jpj', compact('finalBookings'));
    }

    public function uploadFinalFiles(Request $request, $id)
    {
        $request->validate([
            'proofA' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'proofB' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $finalAssessment = FinalAssessment::findOrFail($id);

        if ($request->hasFile('proofA')) {
            $proofAPath = $request->file('proofA')->store('final_assessments', 'public');
            $finalAssessment->proofA = $proofAPath;
        }

        if ($request->hasFile('proofB')) {
            $proofBPath = $request->file('proofB')->store('final_assessments', 'public');
            $finalAssessment->proofB = $proofBPath;
        }

        $finalAssessment->save();

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'final_statusA' => 'required|string',
            'final_statusB' => 'required|string',
        ]);

        $finalAssessment = FinalAssessment::findOrFail($id);
        $finalAssessment->final_statusA = $request->input('final_statusA');
        $finalAssessment->final_statusB = $request->input('final_statusB');
        $finalAssessment->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

}
