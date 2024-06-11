<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FinalAssessment extends Model
{
    use HasFactory;
    protected $table = 'finals';
    protected $fillable = [
        'student_id',
        'course_id',
        'final_date',
        'final_statusA',
        'proofA',
        'final_statusB',
        'proofB',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function course()
{
    return $this->belongsTo(Course::class);
}
public function getRequiredPaymentAttribute()
{
    $course = $this->course;
    $percentage = 0;

    if ($this->final_statusA === 'failed' && $this->final_statusB === 'failed') {
        $percentage = 0.30;
    } elseif ($this->final_statusA === 'failed' || $this->final_statusB === 'failed') {
        $percentage = 0.15;
    }

    return $course->price * $percentage;
}
}
