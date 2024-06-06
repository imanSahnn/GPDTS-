<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Tutor extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'tutor';

    protected $fillable = ['name', 'email','password','ic', 'number', 'picture', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
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
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
