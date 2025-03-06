@extends('layouts.dashboardlayout')
@section('title', 'Student Information System')

@section('content')
    <div class="container-fluid">
      <div class="page-header min-height-250 border-radius-lg mt-4 d-flex flex-column justify-content-end">
        <span class="mask bg-primary opacity-9"></span>
        <div class="w-100 position-relative p-3">
          <div class="d-flex justify-content-between align-items-end">
            <div class="d-flex align-items-center">
              <div class="avatar avatar-xl position-relative me-3">
                <img src="../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
              </div>
              <div>
                <h5 class="mb-1 text-white font-weight-bolder">
                  {{ Auth::user()->name }}
                </h5>
                <p class="mb-0 text-white text-sm">
                  CEO / Co-Founder
                </p>
              </div>
            </div>
            <div class="d-flex align-items-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-white mb-0 btn-sm">
                        Logout
                    </button>
                </form>
            </div>

          </div>
        </div>
      </div>
    </div>

@endsection

<!-- Include Bootstrap Bundle JS (with Popper) globally -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
