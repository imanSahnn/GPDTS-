<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Course extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'course';

    protected $fillable = ['name', 'price', 'detail', 'minimum_hour', 'picture'];

    public function tutors()
    {
        return $this->hasMany(Tutor::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'course_skill');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
