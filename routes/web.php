<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\studentUserController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('students', StudentController::class);

Route::resource('subjects', SubjectController::class);

Route::resource('enrollments', EnrollmentController::class);

Route::resource('grades', GradeController::class);

Route::get('/studentUser', [studentUserController::class, 'studentUser'])->name('studentUser');


Route::get('/studentUser', [studentUserController::class, 'studentUser'])
    ->middleware(['auth', 'verified'])
    ->name('studentUser');

Route::get('/account', function () {
    return view('account');
})->middleware(['auth', 'verified'])->name('account');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
