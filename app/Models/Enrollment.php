<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'subject_id', 'course', 'enrollment_date', 'status'];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function grade()
    {
        return $this->hasOne(Grade::class, 'enrollment_id');
    }

    public function studentUser()
    {
        return $this->belongsTo(User::class, 'student_id'); // Ensure the user model is linked properly
    }

}