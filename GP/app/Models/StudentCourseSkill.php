<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StudentCourseSkill extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'student_course_skill';

    protected $fillable = ['student_id', 'course_id', 'skill_id', 'status_skill'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
