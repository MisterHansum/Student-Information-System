@extends('layouts.dashboardlayout')
@section('title', 'Student Information System')

@section('content')
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center px-3">
                  <h6 class="text-white text-capitalize">Subjects</h6>
                  <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                      <span class="material-symbols-rounded">add</span>
                      Add Subject
                  </a>
              </div>

            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                      <tr>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">ID</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Code</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Subject Code</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Subject Description</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Units</th>
                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($subjects as $subject)
                      <tr>
                          <td class="text-xs font-weight-bold text-center">{{ $loop->iteration }}</td>
                          <td class="text-xs font-weight-bold text-center">{{ $subject->code }}</td>
                          <td class="text-xs font-weight-bold text-center">{{ $subject->subject_code }}</td>
                          <td class="text-xs font-weight-bold text-center">{{ $subject->subject_description }}</td>
                          <td class="text-xs font-weight-bold text-center">{{ $subject->units }}</td>
                          <td class="text-center" style="vertical-align: middle;">
                              <div class="action-buttons d-flex justify-content-center gap-2" style="margin-top: 10px;">

                                  <a href="#" class="edit-subject-btn" data-bs-toggle="modal" data-bs-target="#editStudentModal"
                                      data-id="{{ $subject->id }}" 
                                      data-code="{{ $subject->code }}" 
                                      data-subject_code="{{ $subject->subject_code }}"
                                      data-subject_description="{{ $subject->subject_description }}" 
                                      data-units="{{ $subject->units }}">
                                      <span class="material-symbols-rounded" style="font-size: 24px; color: rgba(0, 0, 0, 0.5); transition: color 0.3s ease;">edit</span>
                                  </a>

                                  <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" style="display: inline;">
                                      @csrf
                                      @method('DELETE')
                                      <a href="#" class="delete-subject-btn" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                        data-id="{{ $subject->id }}" data-name="{{ $subject->code }} {{ $subject->subject_code }}">
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
@endsection

<!-- Add Subject Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <!-- First name and Last name fields in a flex row -->
            <div class="d-flex">
            <!-- Code field -->
            <div class="input-group me-4">
                <span class="material-symbols-rounded mt-2 me-2">confirmation_number</span> <!-- Added me-2 for spacing -->
                <input type="text" name="code" class="form-control" placeholder="Code" required>
            </div>
            <!-- Subject Code field -->
            <div class="input-group">
                <span class="material-symbols-rounded mt-2 me-2">library_books</span> <!-- Added me-2 for spacing -->
                <input type="text" name="subject_code" class="form-control" placeholder="Subject Code" required>
            </div>
            </div>
            <!-- Subject Description field -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">description</span> <!-- Added me-2 for spacing -->
                <input type="text" name="subject_description" class="form-control" placeholder="Subject Description" required>
            </div>
            <!-- Units field -->
            <div class="input-group mt-3">
                <span class="material-symbols-rounded mt-2 me-2">123</span> <!-- Added me-2 for spacing -->
                <input type="text" name="units" class="form-control" placeholder="Units" required>
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

<!-- Edit Subject Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSubjectForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="editSubjectId">

                    <!-- Code Field -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">confirmation_number</span>
                        <input type="text" id="editCode" name="code" class="form-control" placeholder="Code" required>
                    </div>

                    <!-- Subject Code Field -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">library_books</span>
                        <input type="text" id="editSubjectCode" name="subject_code" class="form-control" placeholder="Subject Code" required>
                    </div>

                    <!-- Subject Description Field -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">description</span>
                        <input type="text" id="editSubjectDescription" name="subject_description" class="form-control" placeholder="Subject Description" required>
                    </div>

                    <!-- Units Field -->
                    <div class="input-group mt-3">
                        <span class="material-symbols-rounded mt-2 me-2">123</span>
                        <input type="text" id="editUnits" name="units" class="form-control" placeholder="Units" required>
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
                Are you sure you want to delete <strong id="subjectName"></strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form id="delete-subject-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Attach click event to all delete buttons
        document.querySelectorAll(".delete-subject-btn").forEach(button => {
            button.addEventListener("click", function () {
                let subjectId = this.getAttribute("data-id");
                let subjectName = this.getAttribute("data-name");

                // Update modal content
                document.getElementById("subjectName").textContent = subjectName;

                // Update form action dynamically
                let deleteForm = document.getElementById("delete-subject-form");
                deleteForm.action = `/subjects/${subjectId}`;
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-subject-btn").forEach(button => {
            button.addEventListener("click", function () {
                // Get subject data from button attributes
                let subjectId = this.getAttribute("data-id");
                let code = this.getAttribute("data-code");
                let subject_code = this.getAttribute("data-subject_code");
                let subject_description = this.getAttribute("data-subject_description");
                let units = this.getAttribute("data-units");

                // Populate the modal fields with the current data
                document.getElementById("editSubjectId").value = subjectId;
                document.getElementById("editCode").value = code;
                document.getElementById("editSubjectCode").value = subject_code;
                document.getElementById("editSubjectDescription").value = subject_description;
                document.getElementById("editUnits").value = units;

                // Update form action dynamically
                let editForm = document.getElementById("editSubjectForm");
                editForm.action = `/subjects/${subjectId}`;
            });
        });
    });
</script>



<!-- Add this just before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>