<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Skill;
use App\Models\Student;
use App\Models\Booking;
use App\Models\StudentCourseSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $student = Auth::guard('student')->user();
        $course = Course::find($request->course_id);

        // Assign course to student
        $student->courses()->attach($course->id);

        // Assign all skills related to the course to the student
        $skills = $course->skills;
        foreach ($skills as $skill) {
            StudentCourseSkill::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'skill_id' => $skill->id,
                'status' => 'in_progress',
            ]);
        }

        return redirect()->route('student.courses')->with('success', 'Enrolled in course successfully.');
    }

    public function showProgress($course_id)
    {
        $student = Auth::guard('student')->user();
        $course = Course::findOrFail($course_id);

        $progress = StudentCourseSkill::where('student_id', $student->id)
                                      ->where('course_id', $course->id)
                                      ->with('skill')
                                      ->get();

        return view('student.progress', compact('course', 'progress'));
    }

    public function updateAllSkills(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'required|in:pass,fail,in_progress',
        ]);

        foreach ($request->skills as $id => $status) {
            $skillProgress = StudentCourseSkill::findOrFail($id);
            $skillProgress->status_skill = $status;
            $skillProgress->save();
        }

        return redirect()->back()->with('success', 'All skill statuses updated successfully.');
    }

    public function showStudentProgress()
    {
        $student = Auth::guard('student')->user();
        $courses = $student->courses()->distinct()->with('skills')->get();
        $skillsProgress = StudentCourseSkill::where('student_id', $student->id)->get()->keyBy(function ($item) {
            return $item['course_id'] . '-' . $item['skill_id'];
        });

        // Load all bookings for the student
        $allBookings = Booking::where('student_id', $student->id)
            ->whereNotNull('comment')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->with('course') // Ensure the course relationship is loaded
            ->get();

        // Handle bookings with missing course_id or course_id = 0
        $allBookings->each(function ($booking) {
            $booking->course_name = $booking->course ? $booking->course->name : 'N/A';
        });

        return view('student.learning_progress', compact('courses', 'skillsProgress', 'allBookings'));
    }
}
