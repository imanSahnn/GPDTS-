<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Course;
use App\Models\FinalAssessment;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\Student;
use App\Models\Tutor;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report');
    }

    public function generateReport(Request $request)
    {
        $reportType = $request->input('report_type');
        $data = [];

        switch ($reportType) {
            case 'bookings':
                $query = Booking::with(['student', 'tutor', 'course']);
                break;
            case 'payments':
                $query = Payment::with(['student', 'course']);
                break;
            case 'final_assessments':
                $query = FinalAssessment::with(['student', 'course']);
                break;
            case 'ratings':
                $query = Rating::with(['student', 'tutor', 'course']);
                break;
            case 'students':
                $query = Student::with(['courses', 'bookings', 'payments']);
                break;
            case 'tutors':
                $query = Tutor::with(['course', 'bookings', 'ratings']);
                break;
            default:
                return redirect()->back()->with('error', 'Invalid report type selected.');
        }

        // Apply filters if any
        if ($request->filled('filter_by') && $request->filled('filter_value')) {
            $filterBy = $request->input('filter_by');
            $filterValue = $request->input('filter_value');
            $query->where($filterBy, $filterValue);
        }

        if ($request->filled('sort_by')) {
            $sortBy = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }

        $data = $query->get();

        return view('admin.reportresult', compact('data', 'reportType'));
    }
}
