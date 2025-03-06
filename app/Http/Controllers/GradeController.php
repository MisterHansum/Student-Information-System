<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment; 
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $enrolledStudents = Enrollment::with(['student', 'subject', 'grade'])
            ->where('status', 'enrolled') // Only enrolled students
            ->get();

        return view('grade', compact('enrolledStudents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|numeric|min:1|max:5',
        ]);

        $enrollment = Enrollment::findOrFail($id);
        
        // Check if a grade record exists, otherwise create one
        $grade = Grade::where('enrollment_id', $id)->first();
        if (!$grade) {
            $grade = new Grade();
            $grade->enrollment_id = $id;
        }

        $grade->grade = $request->grade;
        $grade->save();

        return redirect()->back()->with('success', 'Grade updated successfully.');
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);

        // Check if the enrollment has a grade
        $grade = Grade::where('enrollment_id', $id)->first();
        if ($grade) {
            $grade->delete();
        }

        return redirect()->back()->with('success', 'Grade deleted successfully.');
    }

}
