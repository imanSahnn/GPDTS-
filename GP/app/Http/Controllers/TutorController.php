<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tutor;
use App\Models\Course;
use App\Models\Booking;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TutorController extends Controller
{
    public function create()
    {
        $courses = Course::all();
        return view('admin.createtutor', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tutor',
            'password' => 'required|string|confirmed|min:6',
            'ic' => 'required|string|max:20|unique:tutor',
            'number' => 'required|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:course,id',
        ]);

        $tutor = new Tutor();
        $tutor->name = $validatedData['name'];
        $tutor->email = $validatedData['email'];
        $tutor->password = bcrypt($validatedData['password']);
        $tutor->ic = $validatedData['ic'];
        $tutor->number = $validatedData['number'];

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $tutor->picture = $picturePath;
        }

        $tutor->course_id = $validatedData['course_id'];
        $tutor->approved = false; // Set approved to false initially
        $tutor->save();

        return redirect()->route('admin.createtutor')->with('success', 'Tutor created successfully.');
    }

    public function edit($id)
    {
        $tutor = Tutor::find($id);
        $courses = Course::all();
        return view('admin.edittutor', compact('tutor', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $tutor = Tutor::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ic' => 'required|string|max:20',
            'number' => 'required|string|max:15',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:course,id',
        ]);

        $tutor->name = $validatedData['name'];
        $tutor->email = $validatedData['email'];
        $tutor->ic = $validatedData['ic'];
        $tutor->number = $validatedData['number'];

        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('tutor_pictures', 'public');
            $tutor->picture = $imagePath;
        }

        $tutor->course_id = $validatedData['course_id'];
        $tutor->save();

        return redirect()->route('admin.edittutor', $tutor->id)->with('success', 'Tutor updated successfully.');
    }

    public function show(Tutor $tutor)
    {
        return view('admin.viewtutor', ['tutor' => $tutor]);
    }

    public function destroy(Tutor $tutor)
    {
        $tutor->delete();
        return redirect()->route('tutor')->with('success', 'Tutor deleted successfully.');
    }

    public function updateStatus($id)
    {
        $tutor = Tutor::findOrFail($id);
        $tutor->status = $tutor->status === 'active' ? 'inactive' : 'active';
        $tutor->save();
        return redirect()->back()->with('success', 'Tutor status updated successfully.');
    }

    public function index()
    {
        $tutors = Tutor::all();
        return view('admin.tutors', compact('tutors'));
    }

    public function tlogin()
    {
        return view('tutor.tlogin');
    }

    public function tloginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $tutor = Tutor::where('email', $credentials['email'])->first();

        if ($tutor && Hash::check($credentials['password'], $tutor->password)) {
            if (!$tutor->approved) {
                return redirect()->back()->with('error', 'Your account is not approved yet. Please contact admin.');
            }

            Auth::guard('tutor')->login($tutor);
            return redirect()->intended('/tutor/homepage');
        }

        return redirect()->back()->with('error', 'Invalid credentials.');
    }

    public function home()
    {
        $tutor = Auth::guard('tutor')->user();

        if (!$tutor) {
            return redirect()->route('tlogin')->with('error', 'You need to log in first.');
        }

        $profilePicture = $tutor->picture;
        $timezone = 'Asia/Kuala_Lumpur';
        $now = Carbon::now($timezone);

        $startOfToday = $now->copy()->startOfDay();
        $endOfToday = $now->copy()->endOfDay();
        $startOfTomorrow = $now->copy()->addDay()->startOfDay();
        $endOfTomorrow = $now->copy()->addDay()->endOfDay();

        $todaysBookings = Booking::where('tutor_id', $tutor->id)
                                ->where('status', 'approved')
                                ->whereBetween('date', [$startOfToday, $endOfToday])
                                ->get();

        $tomorrowsBookings = Booking::where('tutor_id', $tutor->id)
                                    ->where('status', 'approved')
                                    ->whereBetween('date', [$startOfTomorrow, $endOfTomorrow])
                                    ->get();

        return view('tutor.tutorhomepage', compact('todaysBookings', 'tomorrowsBookings', 'profilePicture'));
    }
    public function listStudents()
    {
        $user = Auth::guard('tutor')->user();

        if (!$user) {
            return redirect()->route('tlogin')->with('error', 'You need to log in first.');
        }

        // Fetch students that have booked with this tutor
        $students = Student::whereHas('bookings', function ($query) use ($user) {
            $query->where('tutor_id', $user->id);
        })->with('bookings')->distinct()->get();

        $profilePicture = $user->picture;

        return view('tutor.tutorstudent', compact('students', 'profilePicture'));
    }

    public function pendingTutors()
    {
        $pendingTutors = Tutor::where('approved', false)->get();
        return view('admin.pendingTutors', compact('pendingTutors'));
    }

    public function approveTutor($id)
    {
        $tutor = Tutor::find($id);
        $tutor->approved = true;
        $tutor->save();

        return redirect()->route('pendingTutors')->with('success', 'Tutor approved successfully.');
    }

    public function rejectTutor($id)
    {
        $tutor = Tutor::find($id);
        $tutor->delete();

        return redirect()->route('pendingTutors')->with('success', 'Tutor rejected and removed successfully.');
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->input('status');
        $booking->save();

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }
    public function showTutorProfile()
    {
        $tutor = Auth::guard('tutor')->user();
        return view('tutor.tutorprofile', compact('tutor'));
    }

    public function updateTutorProfile(Request $request)
    {
        $tutor = Auth::guard('tutor')->user();

        $request->validate([
            'number' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:tutor,email,' . $tutor->id,
            'password' => 'nullable|string|min:6|confirmed',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $tutor->number = $request->number;
        $tutor->email = $request->email;

        if ($request->password) {
            $tutor->password = Hash::make($request->password);
        }

        if ($request->hasFile('picture')) {
            // Delete the old picture if it exists
            if ($tutor->picture) {
                Storage::disk('public')->delete($tutor->picture);
            }

            // Store the new picture
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $tutor->picture = $picturePath;
        }

        $tutor->save();

        return redirect()->route('tutor.tutorprofile')->with('success', 'Profile updated successfully.');
    }
}
