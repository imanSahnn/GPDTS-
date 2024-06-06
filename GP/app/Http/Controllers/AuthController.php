<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Student;
use App\Models\Skill;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register()
    {
        return view('admin.register');
    }
    public function registerPost(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return back()->with('success', 'Register successfully');
    }
    public function login()
    {
        return view('admin.login');
    }
    public function loginPost(Request $request)
    {
        $credetials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credetials)) {
            return redirect('/homepage')->with('success', 'Login Success');
        }

        return back()->with('error', 'Wrong Email or Password');
    }
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }



    //student part

    public function sregister()
    {
        $courses = Course::all();
        return view('student.sregister', compact('courses'));

    }

    public function sregisterPost(Request $request)
    {
        $picturePath = null; // Initialize $picturePath variable

        if ($request->hasFile('picture')) {
            $validator = Validator::make($request->all(), [
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for picture
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8|confirmed',
            'ic' => 'required|string|max:255|unique:students',
            'number' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ic' => $request->ic,
            'number' => $request->number,
            'picture' => $picturePath,
        ]);

        return redirect()->route('slogin')->with('success', 'Student registered successfully');
    }

    public function sstore(Request $request)
    {
        $picturePath = null; // Initialize $picturePath variable

        if ($request->hasFile('picture')) {
            $validator = Validator::make($request->all(), [
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for picture
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => 'required|string|min:8|confirmed',
            'ic' => 'required|string|max:255|unique:students',
            'number' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ic' => $request->ic,
            'number' => $request->number,
            'picture' => $picturePath,
        ]);

        return redirect()->route('student')->with('success', 'Student registered successfully');
    }

    //tutor

    public function tregister()
    {
        $courses = Course::all();
        return view('tutor.tutorregister', compact('courses'));
    }

    public function tregisterPost(Request $request)
    {
        $picturePath = null;

        if ($request->hasFile('picture')) {
            $validator = Validator::make($request->all(), [
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tutor',
            'password' => 'required|string|min:8|confirmed',
            'ic' => 'required|string|max:255|unique:tutor',
            'number' => 'required|string|max:15',
            'course_id' => 'required|exists:course,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Tutor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ic' => $request->ic,
            'number' => $request->number,
            'picture' => $picturePath,
            'course_id' => $request->course_id,
            'approved' => false, // Set approved to false initially
        ]);

        return redirect()->route('tlogin')->with('success', 'Tutor registered successfully. Awaiting admin approval.');
    }
    public function store(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tutor',
            'password' => 'required|string|confirmed|min:6',
            'ic' => 'required|string|max:20|unique:tutor',
            'number' => 'required|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:course,id', // Ensure course_id exists in courses table
        ]);

        // Create new tutor instance
        $tutor = new Tutor();
        $tutor->name = $validatedData['name'];
        $tutor->email = $validatedData['email'];
        $tutor->password = bcrypt($validatedData['password']);
        $tutor->ic = $validatedData['ic'];
        $tutor->number = $validatedData['number'];

        // Handle profile picture upload
        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $tutor->picture = $picturePath;
        }

        // Associate tutor with selected course
        $tutor->course_id = $validatedData['course_id'];

        // Save the new tutor
        $tutor->save();

        return redirect()->route('admin.createtutor')->with('success', 'Tutor created successfully.');
    }

    //course
    public function cstore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:course',
            'price' => 'required|numeric',
            'minimum_hour' => 'required|numeric',
            'detail' => 'required|string|max:1000',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'skills' => 'array',
            'skills.*' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('course_picture', 'public');
        }

        $course = Course::create([
            'name' => $request->name,
            'price' => $request->price,
            'minimum_hour' => $request->minimum_hour,
            'detail' => $request->detail,
            'picture' => $imagePath
        ]);

        // Handle skills
        $skillIds = [];
        if ($request->has('skills')) {
            foreach ($request->skills as $skillName) {
                $skill = Skill::firstOrCreate(['skill_name' => $skillName]);
                $skillIds[] = $skill->id;
            }
            $course->skills()->sync($skillIds);
        }

        return redirect()->route('admin.createcourse')->with('success', 'Course registered successfully.');
    }


}
