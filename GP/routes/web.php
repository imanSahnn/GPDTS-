<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentHomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LearningProgressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('admin.login');
});

//admin
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login');

Route::get('/homepage', [HomeController::class, 'index'])->name('homepage');
Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/student', [HomeController::class, 'student'])->name('student');
Route::get('/tutor', [HomeController::class, 'tutor'])->name('tutor');
Route::get('/course', [HomeController::class, 'course'])->name('course');
Route::get('/students', [HomeController::class, 'student'])->name('students'); //show student

Route::get('/payment', [HomeController::class, 'payment'])->name('payment');

Route::get('/admin/tutors/pending', [HomeController::class, 'pendingTutors'])->name('pendingTutors');
Route::post('/admin/tutors/approve/{id}', [HomeController::class, 'approveTutor'])->name('admin.tutors.approve');
Route::post('/admin/tutors/reject/{id}', [HomeController::class, 'rejectTutor'])->name('admin.tutors.reject');

//reprot
Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
Route::post('/reports/generate', [ReportController::class, 'generateReport'])->name('admin.reportresult');



//tutor
Route::get('/tutor/register', [TutorController::class, 'showRegisterForm'])->name('tutorregister');
Route::post('/tutor/register', [TutorController::class, 'register'])->name('tregister.save');

Route::get('/tlogin', [TutorController::class, 'tlogin'])->name('tlogin'); // Tutor login form
Route::post('/tlogin', [TutorController::class, 'tloginPost'])->name('tlogin.save'); // Tutor login form submission
Route::get('/tutor/homepage', [TutorController::class, 'home'])->name('tutorhomepage'); // Tutor homepage
Route::get('/tutor/register', [AuthController::class, 'tregister'])->name('tutorregister');
Route::post('/tutor/register', [AuthController::class,'tregisterPost'])->name('tregister.save');
// Route to show the list of students for a specific tutor
Route::get('/tutor/students', [TutorController::class, 'listStudents'])->name('tutor.students');
// Route to show the details of a specific student
Route::get('/tutor/student/{id}', [TutorController::class, 'showStudent'])->name('tutor.showStudent');


Route::get('/admin/createtutor', [TutorController::class, 'create'])->name('admin.createtutor');
Route::post('/admin/storetutor', [AuthController::class, 'store'])->name('admin.storetutor');
Route::get('/admin/edittutor/{tutor}', [TutorController::class, 'edit'])->name('admin.edittutor');
Route::post('/admin/update/{tutor}', [TutorController::class, 'update'])->name('admin.update');
Route::get('/admin/viewtutor/{tutor}', [TutorController::class, 'show'])->name('admin.viewtutor');
Route::delete('/admin/destroy/{tutor}', [TutorController::class, 'destroy'])->name('admin.destroy');
Route::patch('admin/tutors/{id}/status', [TutorController::class, 'updateStatus'])->name('admin.updatestatus');

Route::get('admin/tutors', [TutorController::class, 'index'])->name('tutors.index');


    Route::get('/tutor/bookings', [BookingController::class, 'showTutorBookings'])->name('tutor_bookings');
    Route::post('/tutor/bookings/{id}/status', [TutorController::class, 'changeStatus'])->name('tutor.changeStatus');
    Route::get('/student/{id}/{bookingId}', [BookingController::class, 'showStudent'])->name('tutor.studentdetail');
    Route::post('/tutor/update-booking/{id}', [BookingController::class, 'updateBooking'])->name('update_booking');
    Route::post('/tutor/change-booking-status/{id}', [BookingController::class, 'changeBookingStatus'])->name('change_booking_status');


Route::get('/admin/tutors/pending', [TutorController::class, 'pendingTutors'])->name('pendingTutors');
Route::post('/admin/tutors/approve/{id}', [TutorController::class, 'approveTutor'])->name('admin.approveTutor');
Route::post('/admin/tutors/reject/{id}', [TutorController::class, 'rejectTutor'])->name('admin.rejectTutor');
Route::group(['middleware' => ['auth:tutor']], function () {
    Route::get('/tutor/profile', [TutorController::class, 'showTutorProfile'])->name('tutor.profile');
    Route::post('/tutor/profile', [TutorController::class, 'updateTutorProfile'])->name('tutor.profile.update');
});

//learning-progress
Route::post('/tutor/skills/update', [LearningProgressController::class, 'updateAllSkills'])->name('update_all_skills');
Route::post('/update-skill-status/{id}', [LearningProgressController::class, 'updateSkillStatus'])->name('update_skill_status');
Route::get('/learning-progress', [LearningProgressController::class, 'showStudentProgress'])->name('learning_progress');
Route::post('/submit-final', [BookingController::class, 'submitFinal'])->name('submit_final');
Route::get('/view-final/{id}', [BookingController::class, 'viewFinal'])->name('view_final');
Route::post('/schedule-final', [BookingController::class, 'scheduleFinal'])->name('schedule_final');
Route::post('/submit-final-assessment', [BookingController::class, 'submitFinalAssessment'])->name('submit_final_assessment');

Route::get('/final-assessment', [BookingController::class, 'showFinalAssessmentForm'])->name('final_assessment_form');

//student
Route::post('/book-class', [BookingController::class, 'bookClass'])->name('book_class');
Route::group(['middleware' => ['auth:student']], function () {
    Route::get('/student/profile', [StudentController::class, 'showProfile'])->name('student.profile');
    Route::post('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
});


Route::get('/sregister', [AuthController::class, 'sregister'])->name('sregister'); //untuk get the data from field
Route::post('/sregister', [AuthController::class, 'sregisterPost'])->name('sregister.save'); //pass ke database
Route::get('/slogin', [StudentController::class, 'slogin'])->name('slogin'); //login student
Route::post('/slogin', [StudentController::class, 'sloginPost'])->name('slogin.save'); // check ke db and validation

Route::get('/shomepage', [StudentController::class, 'index'])->name('shomepage'); //bawak ke student homepage
Route::get('/update-progress', [StudentController::class, 'updateProgress']);

Route::get('/admin/createstudent', [StudentController::class, 'create'])->name('admin.createstudent');
Route::post('/admin/storestudent', [AuthController::class, 'sstore'])->name('admin.storestudent');
Route::get('/admin/editstudent/{student}', [StudentController::class, 'edit'])->name('admin.editstudent');
Route::post('/admin/studentupdate/{student}', [StudentController::class, 'supdate'])->name('admin.supdate');
Route::get('/admin/viewstudent/{student}', [StudentController::class, 'show'])->name('admin.viewstudent');
Route::delete('/admin/destroy/{student}', [StudentController::class, 'destroy'])->name('admin.destroy');

Route::get('student/booking', [BookingController::class, 'create'])->name('student.booking.create');
Route::post('student/booking', [BookingController::class, 'store'])->name('student.booking.store');
Route::post('custom-password-reset', [StudentController::class, 'reset'])->name('custom.password.reset');

Route::get('/tutor-list', [StudentController::class, 'showTutorList'])->name('tutor_list');
Route::post('/submit-review', [StudentController::class, 'submitReview'])->name('submit_review');


Route::middleware(['auth:student'])->group(function () {
    Route::get('/courses', [StudentController::class, 'courselist'])->name('course_list');
    Route::post('/choose-course', [StudentController::class, 'chooseCourse'])->name('choose_course');
});

Route::group(['middleware' => ['auth:student']], function () {
    Route::get('/book-tutor', [BookingController::class, 'showBookingPage'])->name('bookings');
    Route::get('/book-tutor', [BookingController::class, 'showBookingForm'])->name('bookings');
    Route::post('/fetch-available-tutors', [BookingController::class, 'fetchAvailableTutors'])->name('fetch_available_tutors');
    Route::post('/create-booking', [BookingController::class, 'bookClass'])->name('create_booking');
    Route::post('/choose-tutor', [BookingController::class, 'chooseTutor'])->name('choose_tutor');
    Route::post('edit-booking/{bookingId}', [BookingController::class, 'editBooking'])->name('editBooking');
    Route::delete('/delete-booking/{id}', [BookingController::class, 'deleteBooking'])->name('delete_booking');
    Route::post('/final_assessment/store', [LearningProgressController::class, 'store'])->name('final_assessment.store');
});

Route::get('/student/tutor-list', [StudentController::class, 'showTutorList'])->name('student.tutor_list');

//course
Route::get('/admin/createcourse', [CourseController::class, 'create'])->name('admin.createcourse');
Route::post('/admin/storecourse', [AuthController::class, 'cstore'])->name('admin.storecourse');

// Edit and update course routes
Route::get('/admin/editcourse/{course}', [CourseController::class, 'edit'])->name('admin.editcourse');
Route::post('/admin/courseupdate/{course}', [CourseController::class, 'cupdate'])->name('admin.cupdate');

// View and delete course routes
Route::get('/admin/viewcourse/{course}', [CourseController::class, 'show'])->name('admin.viewcourse');
Route::delete('/admin/destroy/{course}', [CourseController::class, 'destroy'])->name('admin.destroycourse');


//payment

    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('show_payment_form');
    Route::post('/submit-payment', [PaymentController::class, 'submitPayment'])->name('submit_payment');

    Route::get('/confirm-payment', [PaymentController::class, 'showConfirmPayment'])->name('show_confirm_payment');
    Route::patch('/approve-payment/{id}', [PaymentController::class, 'approvePayment'])->name('admin.approve_payment');
    Route::patch('/reject-payment/{id}', [PaymentController::class, 'rejectPayment'])->name('admin.reject_payment');

    //rating
    Route::post('/submit-review/{id}', [BookingController::class, 'submitReview'])->name('submit_review');
