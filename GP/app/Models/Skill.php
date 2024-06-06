<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['skill_name'];

    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_skill');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'skill_student')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
