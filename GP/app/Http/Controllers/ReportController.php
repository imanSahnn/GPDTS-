<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Tutor;
use App\Models\Booking;
use App\Models\Rating;

class ReportController extends Controller
{
    public function showReportForm()
    {
        return view('admin.report_form');
    }

    public function popularityOfCourses()
    {
        $courses = Course::withCount('bookings')
                         ->orderBy('bookings_count', 'desc')
                         ->get();
        return view('admin.popularity_of_courses', compact('courses'));
    }

    public function highestPaidCourse()
    {
        $courses = Course::withSum('payments', 'total_payment')
                         ->orderBy('payments_sum_total_payment', 'desc')
                         ->get();
        return view('admin.highest_paid_course', compact('courses'));
    }

    public function mostPopularTutor()
    {
        $tutors = Tutor::withCount('bookings')
                       ->orderBy('bookings_count', 'desc')
                       ->get();
        return view('admin.most_popular_tutor', compact('tutors'));
    }

    public function ratingOfTutors()
    {
        $tutors = Tutor::with('ratings')
                       ->withAvg('ratings', 'rate')
                       ->get();
        return view('admin.rating_of_tutors', compact('tutors'));
    }

    public function commentsForTutors()
    {
        $tutors = Tutor::with('ratings')
                       ->get();
        return view('admin.comments_for_tutors', compact('tutors'));
    }

    public function mostBookedTime()
    {
        $bookings = Booking::selectRaw('time, COUNT(*) as count')
                           ->groupBy('time')
                           ->orderBy('count', 'desc')
                           ->get();
        return view('admin.most_booked_time', compact('bookings'));
    }
}
