@extends('layouts.dashboardlayout')
@section('title', 'Student Information System')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white text-capitalize ps-3">Student List</h6>
                            <a href="#" class="btn btn-primary btn-sm me-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                                <span class="material-symbols-rounded">add</span>
                                Add Student
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">ID</th>
                                        <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Age</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Address</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr style="height: 53px;">
                                            <td class="text-start text-xs font-weight-bold ps-3">{{ $loop->iteration }}</td> <!-- Sequential numbering -->
                                            <td class="text-start text-xs font-weight-bold ps-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                                            <td class="text-center text-xs font-weight-bold">{{ $student->email }}</td>
                                            <td class="text-center text-xs font-weight-bold">{{ \Carbon\Carbon::parse($student->dob)->age }}</td>
                                            <td class="text-center text-xs font-weight-bold">{{ $student->address }}</td>
                                            <td class="text-center text-xs font-weight-bold" style="vertical-align: middle;">
                                                <div class="action-buttons" style="margin-top: 10px;">
                                                    <a href="#" class="me-2 edit-student-btn" data-bs-toggle="modal" data-bs-target="#editStudentModal"
                                                        data-id="{{ $student->id }}" 
                                                        data-firstname="{{ $student->first_name }}" 
                                                        data-lastname="{{ $student->last_name }}"
                                                        data-email="{{ $student->email }}" 
                                                        data-dob="{{ $student->dob }}" 
                                                        data-address="{{ $student->address }}">
                                                        <span class="material-symbols-rounded" style="font-size: 24px; color: rgba(0, 0, 0, 0.5); transition: color 0.3s ease;">edit</span>
                                                    </a>

                                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display: inline;" title="Delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="#" class="me-2 delete-student-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                                        data-id="{{ $student->id }}" data-name="{{ $student->first_name }} {{ $student->last_name }}">
                                                            <span class="material-symbols-rounded" style="font-size: 24px; color: rgba(0, 0, 0, 0.5); transition: color 0.3s ease;">delete</span>
                                                        </a>
                                                    </form>
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
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <!-- First name and Last name fields in a flex row -->
            <div class="d-flex">
            <!-- First name field -->
            <div class="input-group me-4">
                <span class="material-symbols-rounded mt-2 me-2">person</span> <!-- Added me-2 for spacing -->
                <input type="text" name="first_name" class="form-control" placeholder="First name" required>
            </div>
            <!-- Last name field -->
            <div class="input-group">
                <span class="material-symbols-rounded mt-2 me-2">person</span> <!-- Added me-2 for spacing -->
                <input type="text" name="last_name" class="form-control" placeholder="Last name" required>
            </div>
            </div>
            <!-- Email field -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">mail</span> <!-- Added me-2 for spacing -->
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <!-- Date of birth field -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">calendar_today</span> <!-- Added me-2 for spacing -->
                <input type="date" name="dob" class="form-control" required>
            </div>
            <!-- Address field -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">home</span> <!-- Added me-2 for spacing -->
                <input type="text" name="address" class="form-control" placeholder="Address" required>
            </div>


            <!-- Buttons -->
            <div class="btn-container mt-3">
                <a href="{{ route('students.index') }}" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Hidden input for student ID -->
                    <input type="hidden" name="id" id="editStudentId">
                    <!-- First Name -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">person</span>
                        <input type="text" name="first_name" id="editFirstName" class="form-control" required>
                    </div>

                    <!-- Last Name -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">person</span>
                        <input type="text" name="last_name" id="editLastName" class="form-control" required>
                    </div>

                    <!-- Email -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">mail</span>
                        <input type="email" name="email" id="editEmail" class="form-control" required>
                    </div>

                    <!-- Date of Birth -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">calendar_today</span>
                        <input type="date" name="dob" id="editDob" class="form-control" required>
                    </div>

                    <!-- Address -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">home</span>
                        <input type="text" name="address" id="editAddress" class="form-control" required>
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

<!-- Edit Enrollment Modal -->
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
                    <input type="hidden" name="id" id="editEnrollmentId">

                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">person</span>
                        <input type="text" id="editStudentName" class="form-control" disabled>
                    </div>

                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">book</span>
                        <input type="text" id="editSubject" class="form-control" disabled>
                    </div>

                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">swap_horiz</span>
                        <select class="form-control" name="status" id="editStatus" required>
                            <option value="Enrolled">Enrolled</option>
                            <option value="Dropped">Dropped</option>
                        </select>
                    </div>

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
                let studentName = this.getAttribute("data-student");
                let subject = this.getAttribute("data-subject");
                let status = this.getAttribute("data-status");

                document.getElementById("editEnrollmentId").value = enrollmentId;
                document.getElementById("editStudentName").value = studentName;
                document.getElementById("editSubject").value = subject;
                document.getElementById("editStatus").value = status;

                document.getElementById("editEnrollmentForm").action = `/enrollments/${enrollmentId}`;
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-student-btn").forEach(button => {
            button.addEventListener("click", function () {
                // Get student data from button attributes
                let studentId = this.getAttribute("data-id");
                let firstName = this.getAttribute("data-firstname");
                let lastName = this.getAttribute("data-lastname");
                let email = this.getAttribute("data-email");
                let dob = this.getAttribute("data-dob");
                let address = this.getAttribute("data-address");

                // Populate the modal fields
                document.getElementById("editStudentId").value = studentId;
                document.getElementById("editFirstName").value = firstName;
                document.getElementById("editLastName").value = lastName;
                document.getElementById("editEmail").value = email;
                document.getElementById("editDob").value = dob;
                document.getElementById("editAddress").value = address;

                // Update form action dynamically
                let editForm = document.getElementById("editStudentForm");
                editForm.action = `/students/${studentId}`;
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById('deleteConfirmationModal').addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var studentId = button.getAttribute('data-id');
            var studentName = button.getAttribute('data-name');
            
            document.getElementById('studentName').textContent = studentName;
            var deleteForm = document.getElementById('deleteForm');
            deleteForm.action = `/students/${studentId}`;
        });
    });
</script>


<!-- Add this just before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
