<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dokter\ObatController;
use App\Http\Controllers\dokter\JadwalPeriksaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.profile.dashboard');
    })->name('dokter.dashboard');
});

Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/jadwal-periksa', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal-periksa.index');
    Route::get('/jadwal-periksa/create', [JadwalPeriksaController::class, 'create'])->name('dokter.jadwal-periksa.create');
    Route::post('/jadwal-periksa', [JadwalPeriksaController::class, 'store'])->name('dokter.jadwal-periksa.store');
    Route::patch('/jadwal-periksa/{id}/toggle-status', [JadwalPeriksaController::class, 'toggleStatus'])->name('dokter.jadwal-periksa.toggle-status');
});
Route::prefix('obat')->group(function(){
        Route::get('/', [ObatController::class, 'index'])->name('dokter.obat.index');
        Route::get('/create', [ObatController::class, 'create'])->name('dokter.obat.create');
        Route::post('/', [ObatController::class, 'store'])->name('dokter.obat.store');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('dokter.obat.edit');
        Route::patch('/{id}', [ObatController::class, 'update'])->name('dokter.obat.update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('dokter.obat.destroy');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
});

require __DIR__.'/auth.php';
