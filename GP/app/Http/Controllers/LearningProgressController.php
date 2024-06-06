<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Skill;
use App\Models\Student;
use App\Models\StudentCourseSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningProgressController extends Controller
{
    public function enroll(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course,id',
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


    public function updateSkillStatus(Request $request, $id)
    {
        $request->validate([
            'status_skill' => 'required|in:pass,fail,in_progress',
        ]);

        $skillProgress = StudentCourseSkill::findOrFail($id);
        $skillProgress->status_skill = $request->status_skill;
        $skillProgress->save();

        return redirect()->back()->with('success', 'Skill status updated successfully.');
    }
}
