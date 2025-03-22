<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HrController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HrUploadController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TerminationController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes (ต้อง login ก่อนถึงจะเข้าถึงได้)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');

    // HR Routes
    Route::get('/hr', [App\Http\Controllers\HrController::class, 'index'])->name('hr.index');
    Route::get('/hr/create', [App\Http\Controllers\HrController::class, 'create'])->name('hr.create');
    Route::post('/hr', [App\Http\Controllers\HrController::class, 'store'])->name('hr.store');
    Route::get('/hr/{id}/edit', [App\Http\Controllers\HrController::class, 'edit'])->name('hr.edit');
    Route::put('/hr/{id}', [App\Http\Controllers\HrController::class, 'update'])->name('hr.update');
    Route::delete('/hr/{id}', [App\Http\Controllers\HrController::class, 'destroy'])->name('hr.destroy');
    
    // HR Upload Routes
    Route::get('/hr/upload', [App\Http\Controllers\HrUploadController::class, 'index'])->name('hr.upload');
    Route::post('/hr/upload/employees', [App\Http\Controllers\HrUploadController::class, 'uploadEmployees'])->name('hr.upload.employees');
    Route::post('/hr/upload/performance', [App\Http\Controllers\HrUploadController::class, 'uploadPerformance'])->name('hr.upload.performance');

    // Training Routes
    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/training/create', [TrainingController::class, 'create'])->name('training.create');
    Route::post('/training', [TrainingController::class, 'store'])->name('training.store');
    Route::get('/training/{id}', [TrainingController::class, 'show'])->name('training.show');
    Route::get('/training/{id}/edit', [TrainingController::class, 'edit'])->name('training.edit');
    Route::put('/training/{id}', [TrainingController::class, 'update'])->name('training.update');
    Route::delete('/training/{id}', [TrainingController::class, 'destroy'])->name('training.destroy');

    // Survey Routes
    Route::get('/surveys', [App\Http\Controllers\SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/create', [App\Http\Controllers\SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [App\Http\Controllers\SurveyController::class, 'store'])->name('surveys.store');
    Route::get('/surveys/{id}', [App\Http\Controllers\SurveyController::class, 'show'])->name('surveys.show');
    Route::get('/surveys/{id}/edit', [App\Http\Controllers\SurveyController::class, 'edit'])->name('surveys.edit');
    Route::put('/surveys/{id}', [App\Http\Controllers\SurveyController::class, 'update'])->name('surveys.update');
    Route::delete('/surveys/{id}', [App\Http\Controllers\SurveyController::class, 'destroy'])->name('surveys.destroy');
    Route::get('/surveys-summary', [App\Http\Controllers\SurveyController::class, 'summary'])->name('surveys.summary');

    // Termination Routes
    Route::get('/terminations', [App\Http\Controllers\TerminationController::class, 'index'])->name('terminations.index');
    Route::get('/terminations/create', [App\Http\Controllers\TerminationController::class, 'create'])->name('terminations.create');
    Route::post('/terminations', [App\Http\Controllers\TerminationController::class, 'store'])->name('terminations.store');
    Route::get('/terminations/{id}', [App\Http\Controllers\TerminationController::class, 'show'])->name('terminations.show');
    Route::get('/terminations/{id}/edit', [App\Http\Controllers\TerminationController::class, 'edit'])->name('terminations.edit');
    Route::put('/terminations/{id}', [App\Http\Controllers\TerminationController::class, 'update'])->name('terminations.update');
    Route::delete('/terminations/{id}', [App\Http\Controllers\TerminationController::class, 'destroy'])->name('terminations.destroy');
    Route::get('/terminations-summary', [App\Http\Controllers\TerminationController::class, 'summary'])->name('terminations.summary');

    // Business Routes
    Route::get('/business', [App\Http\Controllers\BusinessController::class, 'index'])->name('business.index');
    Route::get('/business/create', [App\Http\Controllers\BusinessController::class, 'create'])->name('business.create');
    Route::post('/business', [App\Http\Controllers\BusinessController::class, 'store'])->name('business.store');
    Route::get('/business/{id}', [App\Http\Controllers\BusinessController::class, 'show'])->name('business.show');
    Route::get('/business/{id}/edit', [App\Http\Controllers\BusinessController::class, 'edit'])->name('business.edit');
    Route::put('/business/{id}', [App\Http\Controllers\BusinessController::class, 'update'])->name('business.update');
    Route::delete('/business/{id}', [App\Http\Controllers\BusinessController::class, 'destroy'])->name('business.destroy');
    Route::get('/business-summary', [App\Http\Controllers\BusinessController::class, 'summary'])->name('business.summary');

    // Department Routes
    Route::get('/departments', [App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/departments/create', [App\Http\Controllers\DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/departments', [App\Http\Controllers\DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/{id}', [App\Http\Controllers\DepartmentController::class, 'show'])->name('departments.show');
    Route::get('/departments/{id}/edit', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/departments/{id}', [App\Http\Controllers\DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{id}', [App\Http\Controllers\DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::get('/departments-summary', [App\Http\Controllers\DepartmentController::class, 'summary'])->name('departments.summary');
});

// Redirect /home to /dashboard
Route::redirect('/home', '/dashboard');
