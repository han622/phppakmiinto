<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LacakController;
use App\Http\Controllers\StaffTicketController;


Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isStaff()
            ? redirect()->route('staff.dashboard')
            : redirect()->route('mahasiswa.dashboard');
    }

    return redirect()->route('login');
});
// Route latihan lama (boleh dihapus kalau sudah tidak dipakai)
Route::get('/data-mining', function () {
    return view('data-mining');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [DashboardController::class, 'mahasiswa'])->name('mahasiswa.dashboard');
    Route::get('/tiket', [TicketController::class, 'index'])->name('tiket.index');
    Route::get('/tiket/buat', [TicketController::class, 'create'])->name('tiket.create');
    Route::post('/tiket', [TicketController::class, 'store'])->name('tiket.store');
    Route::get('/tiket/{ticket}', [TicketController::class, 'show'])->name('tiket.show');
});

Route::middleware(['auth', 'role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffTicketController::class, 'dashboard'])->name('dashboard');
    Route::get('/tiket', [StaffTicketController::class, 'index'])->name('tiket.index');
    Route::get('/tiket/{ticket}', [StaffTicketController::class, 'show'])->name('tiket.show');
    Route::patch('/tiket/{ticket}/status', [StaffTicketController::class, 'updateStatus'])->name('tiket.status');
    Route::patch('/tiket/{ticket}/publikasi', [StaffTicketController::class, 'moderasi'])->name('tiket.publikasi');
});

Route::get('/lacak', [LacakController::class, 'form'])->name('lacak');
Route::post('/lacak', [LacakController::class, 'cari'])->middleware('throttle:10,1')->name('lacak.cari');