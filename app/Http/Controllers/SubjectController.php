<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject; // Import Subject model

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('id', 'asc')->get();
        return view('subject', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'subject_code' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255',
            'units' => 'required|string|max:255',
        ]);

        // Create the subject
        $subject = new Subject();
        $subject->code = $request->code;
        $subject->subject_code = $request->subject_code;
        $subject->subject_description = $request->subject_description;
        $subject->units = $request->units;
        $subject->save();

        // Redirect to the subject list page after saving
        return redirect()->route('subjects.index')->with('success', 'Subject added successfully.');

    }

    public function destroy($id)
    {
        // Find the subject by ID
        $subject = Subject::findOrFail($id);

        // Delete the subject record
        $subject->delete();

        // Redirect back with a success message
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255',
            'subject_code' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255' . $id,
            'units' => 'required|string|max:255',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }
}

