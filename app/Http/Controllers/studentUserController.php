<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class studentUserController extends Controller
{

    public function studentUser()
    {
        // Assuming you want to fetch enrollments for the logged-in student
        $studentId = 10; 

        $enrollments = Enrollment::with(['subject', 'grade']) // Load related models
            ->where('student_id', $studentId)
            ->get();

        return view('students.studentUser', compact('enrollments'));
    }

}
