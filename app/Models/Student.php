<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Define which columns are mass-assignable
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'dob', 
        'address'
    ];

    // Optionally, you can cast attributes like dates
    protected $casts = [
        'dob' => 'datetime',
    ];

    // You can define relationships later, such as with Enrollment or Grade models.
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments');
    }
}
