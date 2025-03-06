@extends('layouts.dashboardlayout')
@section('title', 'Student Information System')

@section('content')
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Enrolled Students</h6>
                            <a href="#" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#addEnrollmentModal">
                                <span class="material-symbols-rounded">add</span>
                                Enroll
                            </a>

                        </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                      <tr>
                          <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">ID</th>
                          <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Student</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subjects</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Enrollment Date</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($enrollments as $enrollment)
                          <tr style="height: 53px;">
                              <td class="text-start text-xs font-weight-bold ps-3">{{ $loop->iteration }}</td>
                              <td class="text-start text-xs font-weight-bold py-2 px-3">
                                  {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}
                              </td>
                              <td class="text-center text-xs font-weight-bold py-2 px-3">
                                  {{ $enrollment->subject->subject_description }}
                              </td>
                              <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->course }}</td>
                              <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->created_at->format('Y-m-d') }}</td>
                              <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->status }}</td>

                              <td class="text-center text-xs font-weight-bold py-2 px-3">
                                  <div class="d-flex justify-content-center align-items-center gap-2">
                                      <!-- Edit Button -->
                                      <div class="d-flex align-items-center">
                                          <a href="#" class="edit-enrollment-btn" data-bs-toggle="modal" data-bs-target="#editEnrollmentModal"
                                                        data-id="{{ $enrollment->id }}" 
                                                        data-student="{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}"
                                                        data-subject="{{ $enrollment->subject->subject_description }}"
                                                        data-status="{{ $enrollment->status }}">
                                                        <span class="material-symbols-rounded" style="font-size: 24px; color: rgba(0, 0, 0, 0.5); transition: color 0.3s ease;">edit</span>
                                                    </a>
                                      </div>

                                      <!-- Delete Button -->
                                      <div class="d-flex align-items-center">
                                          <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline p-0 m-0">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="border-0 bg-transparent p-0 delete-enrollment-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                                  data-id="{{ $enrollment->id }}" 
                                                  data-name="{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}">
                                                  <span class="material-symbols-rounded" style="font-size: 24px; color: rgba(0, 0, 0, 0.5); transition: color 0.3s ease;">delete</span>
                                              </button>
                                          </form>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

<!-- Modal -->
<div class="modal fade" id="addEnrollmentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Enroll Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('enrollments.store') }}" method="POST">
            @csrf
            <!-- Student Selection -->
            <div class="input-group">
                <span class="material-symbols-rounded mt-2 me-2">person</span>
                <select class="form-control" name="student_id" id="student_id" required>
                    <option value="" disabled selected>Select Student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subject Selection -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">book</span>
                <select class="form-control" name="subject_id" id="subject_id" required>
                    <option value="" disabled selected>Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->subject_description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">school</span> <!-- Added me-2 for spacing -->
                <input type="text" name="course" class="form-control" placeholder="Course" required>
            </div>

            <!-- Enrollment Date -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">calendar_today</span>
                <input type="date" name="enrollment_date" class="form-control" required>
            </div>

            <!-- Buttons -->
            <div class="btn-container mt-3">
                <a href="#" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary">Enroll</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="studentName"></strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editEnrollmentModal" tabindex="-1" aria-labelledby="editEnrollmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEnrollmentModalLabel">Edit Enrollment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEnrollmentForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Enrollment ID -->
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

                    <!-- Course (Editable) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">school</span>
                        <input type="text" name="course" id="editCourse" class="form-control" required>
                    </div>

                    <!-- Enrollment Status (Editable) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">check_circle</span>
                        <select class="form-control" name="status" id="editStatus" required>
                            <option value="Enrolled">Enrolled</option>
                            <option value="Dropped">Dropped</option>
                        </select>
                    </div>

                    <!-- Enrollment Date (Editable) -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">calendar_today</span>
                        <input type="date" name="enrollment_date" id="editEnrollmentDate" class="form-control" required>
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
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-enrollment-btn").forEach(button => {
        button.addEventListener("click", function () {
            let enrollmentId = this.getAttribute("data-id");

            fetch(`/enrollments/${enrollmentId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("editEnrollmentId").value = data.id;
                    document.getElementById("editStudentName").value = data.student_name;
                    document.getElementById("editSubject").value = data.subject;
                    document.getElementById("editCourse").value = data.course;
                    document.getElementById("editStatus").value = data.status;
                    document.getElementById("editEnrollmentDate").value = data.enrollment_date;

                    // Set form action dynamically
                    document.getElementById("editEnrollmentForm").action = `/enrollments/${enrollmentId}`;
                });
        });
    });
});

</script>




<script>
    document.addEventListener("DOMContentLoaded", function () {
    var deleteModal = document.getElementById('deleteConfirmationModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var enrollmentId = button.getAttribute('data-id');
            var studentName = button.getAttribute('data-name');

            document.getElementById('studentName').textContent = studentName;
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/enrollments/${enrollmentId}`; // Ensure it deletes enrollments, not students
        });
    });

</script>

<!-- Include Bootstrap Bundle JS (with Popper) globally -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


