<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\Booking;
use App\Models\StudentCourseSkill;
use App\Models\Course;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function showBookingForm()
    {
        $user = Auth::guard('student')->user();
        $profilePicture = $user->picture;
        $selectedTutorId = $user->selected_tutor_id;
        $hasTutor = !is_null($selectedTutorId);

        // Ensure $chosenCourses is correctly set and remove duplicates
        $chosenCourses = $user->courses->unique('id');

        // Calculate if each course meets the 15% payment requirement
        $coursePaymentStatus = [];
        foreach ($chosenCourses as $course) {
            $totalPaid = $user->payments()->where('course_id', $course->id)->where('status', 'approved')->sum('total_payment');
            $coursePaymentStatus[$course->id] = $totalPaid >= 0.15 * $course->price;
        }

        if ($hasTutor) {
            $tutors = Tutor::where('id', $selectedTutorId)->get();
        } else {
            $tutors = Tutor::where('status', 'active')
                           ->whereHas('course', function($query) use ($user) {
                               $query->whereIn('id', $user->courses->pluck('id')->unique());
                           })
                           ->get();
        }

        $bookings = Booking::where('student_id', $user->id)
                           ->orderByRaw("FIELD(status, 'approved', 'pending', 'rejected')")
                           ->with('tutor', 'course')
                           ->get();

        // Pass $coursePaymentStatus to the view
        return view('student.booking', compact('tutors', 'profilePicture', 'hasTutor', 'bookings', 'chosenCourses', 'coursePaymentStatus'));
    }

    public function chooseTutor(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutor,id',
        ]);

        $user = Auth::guard('student')->user();
        $user->selected_tutor_id = $request->tutor_id;
        $user->save();

        return redirect()->route('bookings')->with('success', 'Tutor selected successfully!');
    }
    public function fetchAvailableTutors(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|in:08:30,10:00,11:30,14:00,15:30',
            'course_id' => 'required|exists:course,id',
        ]);

        $date = $request->input('date');
        $time = $request->input('time');
        $course_id = $request->input('course_id');

        $availableTutors = Tutor::where('status', 'active')
            ->where('course_id', $course_id)
            ->whereDoesntHave('bookings', function ($query) use ($date, $time) {
                $query->where('date', $date)->where('time', $time);
            })->get();

        $chosenCourses = Auth::guard('student')->user()->courses->unique('id');

        return redirect()->back()->with(['availableTutors' => $availableTutors, 'chosenCourses' => $chosenCourses, 'date' => $date, 'time' => $time]);
    }
    public function bookClass(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutor,id',
            'course_id' => 'required|exists:course,id',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $studentId = auth()->guard('student')->id();
        $date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $time = $request->input('time');

        // Check for existing bookings with the same date and time
        $existingBooking = Booking::where('student_id', $studentId)
                                  ->where('date', $date)
                                  ->where('time', $time)
                                  ->whereIn('status', ['pending', 'approved'])
                                  ->exists();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'You already have a booking for this date and time.');
        }

        // Create the new booking
        Booking::create([
            'student_id' => $studentId,
            'tutor_id' => $request->input('tutor_id'),
            'course_id' => $request->input('course_id'),
            'date' => $date,
            'time' => $time,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking created successfully. Awaiting approval.');
    }

    public function editBooking(Request $request, $bookingId)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|in:08:30,10:00,11:30,14:00,15:30',
        ]);

        $booking = Booking::findOrFail($bookingId);
        $selectedTutorId = $booking->tutor_id;

        $isBooked = Booking::where('tutor_id', $selectedTutorId)
                           ->where('date', $request->date)
                           ->where('time', $request->time)
                           ->where('id', '!=', $bookingId)
                           ->exists();

        if ($isBooked) {
            return redirect()->route('bookings')->with('error', 'The selected time slot is already booked.');
        }

        // Change status to 'pending' if it is currently 'approved'
        if ($booking->status == 'approved') {
            $booking->status = 'pending';
        }

        $booking->date = $request->date;
        $booking->time = $request->time;
        $booking->save();

        return redirect()->route('bookings')->with('success', 'Booking updated successfully!');
    }

    public function deleteBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->delete();

        return redirect()->route('bookings')->with('success', 'Booking deleted successfully!');
    }

    public function changeBookingStatus(Request $request, $bookingId)
    {
        $request->validate([
            'status' => 'required|in:pending,rejected,approved',
        ]);

        $booking = Booking::findOrFail($bookingId);

        // Check if there is any existing approved booking for the same date and time
        $existingApprovedBooking = Booking::where('date', $booking->date)
                                          ->where('time', $booking->time)
                                          ->where('status', 'approved')
                                          ->first();

        // If there's an existing approved booking, prevent approving the current booking
        if ($request->status === 'approved' && $existingApprovedBooking) {
            return redirect()->back()->with('error', 'Another booking for the same date and time is already approved.');
        }

        // Update booking status
        $booking->status = $request->status;
        $booking->save();

        return redirect()->back()->with('success', 'Booking status updated successfully.');
    }

    public function showTutorBookings()
    {
        $user = Auth::guard('tutor')->user();
        $profilePicture = $user->picture;
        $bookings = Booking::where('tutor_id', $user->id)->with('student')->get();

        return view('tutor.tutorbooking', compact('bookings', 'profilePicture'));
    }

    public function showStudent($id, $bookingId)
    {
        $tutor = Auth::guard('tutor')->user();
        $student = Student::with(['courses.skills'])->findOrFail($id);
        $selectedBooking = Booking::where('id', $bookingId)
                                   ->where('student_id', $id)
                                   ->where('tutor_id', $tutor->id)
                                   ->with('course')
                                   ->firstOrFail();

        // Fetch skills from student_course_skill table related to the tutor's course
        $skillsProgress = StudentCourseSkill::where('student_id', $id)
                                            ->where('course_id', $selectedBooking->course_id)
                                            ->get();

        return view('tutor.studentdetail', compact('student', 'skillsProgress', 'selectedBooking'));
    }

    public function updateBooking(Request $request, $id)
    {
        $request->validate([
            'attendance_status' => 'required|in:present,absent',
            'comment' => 'nullable|string|max:400',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->attendance_status = $request->input('attendance_status');
        $booking->comment = $request->input('comment');

        // Change status to 'pending' if it is currently 'approved'
        if ($booking->status == 'approved') {
            $booking->status = 'pending';
        }

        $booking->save();

        return redirect()->route('studentdetail', ['id' => $booking->student_id])->with('success', 'Booking updated successfully.');
    }

    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rate' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($id);
        $student = Auth::guard('student')->user();

        Rating::create([
            'student_id' => $student->id,
            'tutor_id' => $booking->tutor_id,
            'course_id' => $booking->course_id,
            'rate' => $request->rate,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}
