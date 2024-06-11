<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\Course;

class ReportController extends Controller
{
    public function showReportForm()
    {
        $students = Student::all();
        $tutors = Tutor::all();
        $courses = Course::all();
        return view('admin.report_form', compact('students', 'tutors', 'courses'));
    }

    public function generateStudentReport(Request $request)
    {
        $courseId = $request->input('course_id');
        $tutorId = $request->input('tutor_id');
        $query = Student::query();

        if ($courseId) {
            $query->whereHas('courses', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        if ($tutorId) {
            $query->whereHas('bookings', function ($q) use ($tutorId) {
                $q->where('tutor_id', $tutorId);
            });
        }

        $students = $query->get();
        return view('admin.student_report', compact('students'));
    }

    public function generateTutorReport(Request $request)
    {
        $courseId = $request->input('course_id');
        $query = Tutor::query();

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        $tutors = $query->get();
        return view('admin.tutor_report', compact('tutors'));
    }

    public function generateCourseReport(Request $request)
    {
        $courseId = $request->input('course_id');
        $courses = Course::when($courseId, function ($query, $courseId) {
            return $query->where('id', $courseId);
        })->get();
        return view('admin.course_report', compact('courses'));
    }
}

