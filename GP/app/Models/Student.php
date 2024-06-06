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
        'name', 'email', 'password', 'ic', 'number', 'picture'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_student')
                    ->withPivot('status')
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

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
