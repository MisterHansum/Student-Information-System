<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Retrieve students ordered by ID (ascending)
        $students = Student::orderBy('id', 'asc')->get();
        return view('student', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'dob' => 'required|date',
            'address' => 'required|string',
        ]);

        // Create the student
        $student = new Student();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->dob = $request->dob;
        $student->address = $request->address;
        $student->save();

        // Redirect to the student list page after saving
        return redirect()->route('students.index')->with('success', 'Student added successfully.');

    }

    public function destroy($id)
    {
        // Find the student by ID
        $student = Student::findOrFail($id);

        // Delete the student record
        $student->delete();

        // Redirect back with a success message
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $id,
            'dob' => 'required|date',
            'address' => 'required|string',
        ]);

        $student = Student::findOrFail($id);
        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    // More methods for edit, update, and delete...
}
