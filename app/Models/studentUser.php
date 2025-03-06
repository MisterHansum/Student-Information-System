<?php

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

// Get the currently logged-in student
$student = Auth::user()->student;

// Fetch enrolled subjects and related grades
$enrollments = Enrollment::where('student_id', $student->id)
    ->where('status', 'Enrolled')
    ->with(['subject', 'grade']) // Assuming you have a Grade model
    ->get();
?>

