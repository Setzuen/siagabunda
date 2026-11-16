<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

// Halaman Awal (Landing / Login)
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isHospitalStaff()
            ? redirect()->route('hospital.dashboard')
            : redirect()->route('patient.dashboard');
    }

    return view('landing');
})->name('home');

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Ruang Ibu Hamil (Responden / Pasien)
Route::middleware(['auth', 'role:patient'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
        Route::post('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
        Route::get('/education', [PatientController::class, 'education'])->name('education');
        Route::get('/checklist', [PatientController::class, 'checklist'])->name('checklist');
        Route::post('/checklist/{checklist}', [PatientController::class, 'updateChecklist'])->name('checklist.update');
        Route::get('/reminders', [PatientController::class, 'reminders'])->name('reminders');
        Route::post('/reminders', [PatientController::class, 'storeReminder'])->name('reminders.store');
        Route::post('/reminders/{schedule}/toggle', [PatientController::class, 'toggleReminder'])->name('reminders.toggle');
        Route::get('/emergency', [PatientController::class, 'emergency'])->name('emergency');
    });

// Ruang Rumah Sakit (Bidan / Nakes / Admin)
Route::middleware(['auth', 'role:hospital_staff'])
    ->prefix('hospital')
    ->name('hospital.')
    ->group(function () {
        Route::get('/dashboard', [HospitalController::class, 'dashboard'])->name('dashboard');
        Route::get('/patients/{patient}', [HospitalController::class, 'showPatient'])->name('patients.show');
        Route::post('/patients/{patient}/risk', [HospitalController::class, 'updatePatientRisk'])->name('patients.risk');
        Route::post('/patients/{patient}/schedules', [HospitalController::class, 'storePatientSchedule'])->name('patients.schedules');
        Route::get('/export-csv', [HospitalController::class, 'exportCsv'])->name('export.csv');
        Route::get('/education', [HospitalController::class, 'education'])->name('education');
        Route::post('/education', [HospitalController::class, 'storeEducation'])->name('education.store');
        Route::delete('/education/{education}', [HospitalController::class, 'destroyEducation'])->name('education.destroy');
    });
