<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Student;
use App\Models\Course;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\StudentCourseSkill;

class StudentController extends Controller
{
    public function index()
    {
        // Retrieve the authenticated user
        $user = Auth::guard('student')->user();

        // Retrieve the user's profile picture filename
        $profilePicture = Student::where('id', $user->id)->value('picture');

        // Pass the authenticated user's profile picture filename to the view
        return view('student.shomepage', compact('profilePicture'));
        return view('student.shomepage', compact('profilePicture'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $courses = Course::all();
        return view('admin.editstudent', compact('student', 'courses'));
    }

    public function supdate(Request $request, Student $student)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'ic' => 'required|string|max:20|unique:students,ic,' . $student->id,
            'number' => 'required|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id',
        ]);

        // Update the student data
        $student->name = $validatedData['name'];
        $student->email = $validatedData['email'];
        $student->ic = $validatedData['ic'];
        $student->number = $validatedData['number'];
        $student->course_id = $validatedData['course_id'];

        // Handle picture upload
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('student_pictures', 'public');
            $student->picture = $imagePath;
        }

        $student->save();

        return redirect()->route('admin.editstudent', $student->id)->with('success', 'Student updated successfully.');
    }


    public function show(Student $student)
    {
        return view('admin.viewstudent', ['student' => $student]);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete the student
        $student->delete();

        // Redirect to a specific route with a success message
        return redirect()->route('student')->with('success', 'Student deleted successfully.');
    }
    public function create()
    {
        $courses = Course::all();
        return view('admin.createstudent', ['courses' => $courses]);
    }

    public function slogin()
    {
        return view('student.slogin');
    }

    public function sloginPost(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->route('shomepage');
        } else {
            return back()->withInput()->withErrors([
                'email' => 'Invalid email or password.'
            ]);
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'ic_number' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)
                    ->where('ic_number', $request->ic_number)
                    ->first();

        if ($user) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password has been reset successfully.');
        }

        return back()->withErrors(['error' => 'Invalid email or IC number.']);
    }
    public function showTutorList()
    {
        $student = Auth::guard('student')->user();
        $courseIds = $student->courses()->pluck('course.id');
        $tutors = Tutor::whereIn('course_id', $courseIds)->with('course')->orderBy('created_at', 'desc')->get();

        foreach ($tutors as $tutor) {
            $tutor->average_rating = $tutor->ratings()->avg('rate'); // Calculate average rate
        }

        return view('student.tutorlist', compact('tutors'));
    }


    public function courselist()
    {
        $user = Auth::guard('student')->user();
        $profilePicture = Student::where('id', $user->id)->value('picture');
        $courses = Course::all();
        $userCourses = $user->courses->pluck('id')->toArray(); // Get IDs of courses the user has already chosen
        return view('student.course_list', compact('courses', 'profilePicture', 'userCourses'));
    }

    public function chooseCourse(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:course,id',
        ]);

        $student = Auth::guard('student')->user();

        if (!$student) {
            return back()->withErrors(['message' => 'User not authenticated']);
        }

        try {
            $course = Course::findOrFail($request->course_id);

            // Attach the course to the student
            $student->courses()->attach($course->id);

            // Assign all skills related to the course to the student
            foreach ($course->skills as $skill) {
                StudentCourseSkill::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'skill_id' => $skill->id,
                    'status' => 'in_progress',
                ]);
            }

            return back()->with('success', 'Course and related skills successfully added!');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Failed to add course: ' . $e->getMessage()]);
        }
    }
    public function showLearningProgress()
    {
        $student = Auth::guard('student')->user();
        $courses = $student->courses()->with('skills')->get();
        $skillsProgress = StudentCourseSkill::where('student_id', $student->id)->with('skill')->get();

        return view('student.learning_progress', compact('courses', 'skillsProgress'));
    }

    public function showProfile()
    {
        $student = Auth::guard('student')->user();
        return view('student.studentprofile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::guard('student')->user();

        $request->validate([
            'number' => 'required|string|max:15' ,
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'password' => 'nullable|string|min:6|confirmed',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $student->number = $request->number;
        $student->email = $request->email;

        if ($request->password) {
            $student->password = Hash::make($request->password);
        }

        if ($request->hasFile('picture')) {
            // Delete the old picture if it exists
            if ($student->picture) {
                Storage::disk('public')->delete($student->picture);
            }

            // Store the new picture
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $student->picture = $picturePath;
        }

        $student->save();

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }

    public function showFinalAssessments()
    {
        $courses = Course::with(['students' => function ($query) {
            $query->whereHas('bookings', function ($bookingQuery) {
                $bookingQuery->where('attendance_status', 'present')
                    ->groupBy('student_id')
                    ->havingRaw('SUM(1.5) > 10'); // Check for over 10 hours of present status bookings
            });
        }])->get();

        return view('final_assessments.index', compact('courses'));
    }


}

