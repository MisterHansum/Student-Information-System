@extends('layouts.dashboardlayout')
@section('title', 'Student Information System')

@section('content')
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Grades</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
    <tr>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-5">Name</th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Grade</th>
        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
    </tr>
</thead>
<tbody>
    @foreach($enrolledStudents as $enrollment)
    <tr style="height: 53px;">
        <td class="text-center text-xs font-weight-bold">{{ $loop->iteration }}</td>
        <td class="text-start text-xs font-weight-bold py-2 px-4">
            {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}
        </td>
        <td class="text-center text-xs font-weight-bold py-2 px-3">
            {{ $enrollment->subject->subject_description }}
        </td>
        <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->course }}</td>
        <td class="text-center text-xs font-weight-bold py-2 px-3">
            {{ $enrollment->grade->grade ?? 'Add Grade' }}
        </td>
        <td class="text-center text-xs font-weight-bold py-2 px-3">
            <span 
                class="material-symbols-rounded edit-btn" 
                style="font-size: 24px; color: rgba(0, 0, 0, 0.5); transition: color 0.3s ease; cursor: pointer;"
                data-bs-toggle="modal" 
                data-bs-target="#editGradeModal"
                data-id="{{ $enrollment->id }}" 
                data-student_name="{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}"
                data-subject="{{ $enrollment->subject->subject_description }}"
                data-course="{{ $enrollment->course }}"
                data-grade="{{ $enrollment->grade->grade ?? 'N/A' }}"
            >
                edit
            </span>
        </td>
    </tr>
    @endforeach

    @if($enrolledStudents->isEmpty())
    <tr>
        <td colspan="6" class="text-center py-3">No enrolled students found.</td>
    </tr>
    @endif
</tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection

<!-- Edit Grade Modal -->
<div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGradeModalLabel">Edit Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editGradeForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hidden input for Enrollment ID -->
                    <input type="hidden" name="id" id="editEnrollmentId">

                    <!-- Student Name (Read-Only) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">person</span>
                        <input type="text" id="editStudentName" class="form-control" readonly>
                    </div>

                    <!-- Subject (Read-Only) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">book</span>
                        <input type="text" id="editSubject" class="form-control" readonly>
                    </div>

                    <!-- Course (Read-Only) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">school</span>
                        <input type="text" id="editCourse" class="form-control" readonly>
                    </div>

                    <!-- Grade (Editable) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">grade</span>
                        <input type="number" name="grade" id="editGrade" class="form-control" step="0.01" min="1.00" max="5.00" required>
                    </div>

                    <!-- Buttons -->
                    <div class="btn-container mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle Edit Button Click
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function() {
                let enrollmentId = this.getAttribute("data-id");
                let studentName = this.getAttribute("data-student_name");
                let subject = this.getAttribute("data-subject");
                let course = this.getAttribute("data-course");
                let grade = this.getAttribute("data-grade");

                grade = isNaN(parseFloat(grade)) ? "" : parseFloat(grade).toFixed(2);

                document.getElementById("editEnrollmentId").value = enrollmentId;
                document.getElementById("editStudentName").value = studentName;
                document.getElementById("editSubject").value = subject;
                document.getElementById("editCourse").value = course;
                document.getElementById("editGrade").value = grade;

                document.getElementById("editGradeForm").action = `/grades/${enrollmentId}`;
            });
        });
    });
</script>


<!-- Include Bootstrap Bundle JS (with Popper) globally -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></scrip>