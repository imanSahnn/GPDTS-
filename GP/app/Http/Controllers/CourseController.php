<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Skill;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function edit(Course $course)
    {
        return view('admin.editcourse', ['course' => $course]);
    }

    public function cupdate(Request $request, $id) // Changed to update from cupdate for consistency
    {
        $course = Course::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:15',
            'detail' => 'required|string|max:255',
            'skills' => 'array',
            'skills.*' => 'string|max:255'
        ]);

        $course->update($validatedData);

        // Sync skills
        $skillIds = [];
        if ($request->has('skills')) {
            foreach ($validatedData['skills'] as $skillName) {
                $skill = Skill::firstOrCreate(['skill_name' => $skillName]);
                $skillIds[] = $skill->id;
            }
            $course->skills()->sync($skillIds);
        }

        return redirect()->route('admin.editcourse', $course->id)->with('success', 'Course updated successfully.');
    }

    public function show(Course $course)
    {
        // Eager load the skills relationship on the provided course instance
        $course->load('skills');
        return view('admin.viewcourse', ['course' => $course]);
    }

    public function destroy(Course $course)
    {
        // Delete the course
        $course->delete();

        // Redirect to a specific route with a success message
        return redirect()->route('admin.course')->with('success', 'Course deleted successfully.');
    }

    public function create()
    {
        return view('admin.createcourse'); // Ensure this view exists
    }

}
