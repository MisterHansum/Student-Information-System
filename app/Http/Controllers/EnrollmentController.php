<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'subject'])->orderBy('id', 'asc')->get();
        $students = Student::all();  // Fetch all students
        $subjects = Subject::all();  // Fetch all subjects

        return view('enrollment', compact('enrollments', 'students', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'course' => 'required|string|max:255',
            'enrollment_date' => 'required|date',
        ]);

        // Create enrollment
        $enrollment = Enrollment::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'course' => $request->course,
            'enrollment_date' => $request->enrollment_date,
            'status' => 'Enrolled',
        ]);

        // Fetch student details
        $student = Student::find($request->student_id);
        $existingUser = User::where('email', $student->email)->first();

        if (!$existingUser) {
            // Create a new user account for the student
            User::create([
                'name' => $student->first_name . ' ' . $student->last_name,
                'email' => $student->email, // Use email from student
                'password' => Hash::make('12345678'), // Set default password
                'role' => 'student', // Assign student role
                'student_id' => $student->id, // Link user to student
            ]);
        }

        return redirect()->back()->with('success', 'Student enrolled successfully and account created.');
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }

    // Update an enrollment record
    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $validatedData = $request->validate([
            'course' => 'required|string|max:255',
            'status' => 'required|in:Enrolled,Dropped',
            'enrollment_date' => 'required|date',
        ]);

        $enrollment->update($validatedData);

        return redirect()->back()->with('success', 'Enrollment updated successfully!');
    }


    public function edit($id)
    {
        $enrollment = Enrollment::with(['student', 'subject'])->findOrFail($id);

        return response()->json([
            'id' => $enrollment->id,
            'student_name' => $enrollment->student->first_name . ' ' . $enrollment->student->last_name,
            'subject' => $enrollment->subject->subject_description,
            'course' => $enrollment->course,
            'status' => $enrollment->status,
            'enrollment_date' => $enrollment->enrollment_date,
        ]);
    }




}
