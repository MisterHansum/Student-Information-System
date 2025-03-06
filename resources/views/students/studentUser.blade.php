@extends('layouts.studentdashboardlayout')

@section('content')
    <div class="container-fluid py-2">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                    <h6 class="text-white text-capitalize ps-3">Student Grade</h6>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                      <tr>
                          <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject Code</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subjects</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Grade</th>
                          <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Units</th>
                      </tr>
                  </thead>
                  <tbody>
                      @if ($enrollments->isEmpty())
                          <tr>
                              <td colspan="6" class="text-center">No enrollments found</td>
                          </tr>
                      @else
                          @foreach ($enrollments as $enrollment)
                              <tr style="height: 53px;">
                                  <td class="text-start text-xs font-weight-bold py-2 px-3 ps-4">{{ $enrollment->course ?? 'N/A' }}</td>
                                  <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->subject->code ?? 'N/A' }}</td>
                                  <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->subject->subject_description ?? 'N/A' }}</td>
                                  <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->grade->grade ?? 'Add Grade' }}</td>
                                  <td class="text-center text-xs font-weight-bold py-2 px-3">{{ $enrollment->subject->units ?? 'N/A' }}</td>
                              </tr>
                          @endforeach
                      @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
