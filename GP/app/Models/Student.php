<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'name', 'email', 'password', 'ic', 'number', 'picture', 'lesen_picture','lesen_picture_date','lesen_picture_status','next_upload_due_date','course_id', 'status', 'result'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'student_course_skill', 'student_id', 'skill_id')
                    ->withPivot('course_id', 'status')
                    ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getCurrentTotalAttribute()
    {
        return $this->payments()->where('status', 'approved')->sum('total_payment');
    }
    public function hasPaidMinimum($courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $currentTotal = $this->payments()->where('course_id', $courseId)->where('status', 'approved')->sum('total_payment');
            return $currentTotal >= 0.15 * $course->price;
        }
        return false;
    }
    public function hasPaidFullPrice($courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $currentTotal = $this->payments()
                ->where('course_id', $courseId)
                ->where('status', 'approved')
                ->sum('total_payment');
            return $currentTotal >= $course->price;
        }
        return false;
    }
    public function isEligibleForFinal($courseId)
    {
        // Check if the student has paid the full price for the course
        if (!$this->hasPaidFullPrice($courseId)) {
            return false;
        }

        // Check if the student has bookings with a present status totaling over 10 hours
        $totalPresentHours = $this->bookings()
            ->where('course_id', $courseId)
            ->where('attendance_status', 'present')
            ->get()
            ->sum(function ($booking) {
                return 1.5; // Each booking is 1.5 hours
            });

        if ($totalPresentHours < 10) {
            return false;
        }

        // Check if the student has passed the required skills for the course
        $passedSkills = $this->skills()
            ->wherePivot('status_skill', 'pass')
            ->wherePivot('course_id', $courseId)
            ->count();

        $requiredSkills = Course::find($courseId)->skills->count();

        return $passedSkills === $requiredSkills;
    }

    public function getEligibleCoursesForFinal()
    {
        $eligibleCourses = $this->courses->filter(function ($course) {
            return $this->isEligibleForFinal($course->id);
        })->unique('id'); // Ensure uniqueness based on course ID

        return $eligibleCourses;
    }
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
