<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Hanya mahasiswa yang bisa membuat laporan
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'dpa') {
        $laporans = \App\Models\Laporan::latest()->paginate(10);
    } else {
        $laporans = \App\Models\Laporan::where('mahasiswa_id', $user->id)->latest()->paginate(10);
    }
    return view('dashboard', compact('laporans','user'));
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth','role:mahasiswa'])->group(function(){
    Route::resource('laporan', \App\Http\Controllers\LaporanController::class);
});

// Hanya DPA (admin) yang bisa mengelola mahasiswa, dosen, dan melihat semua laporan
Route::middleware(['auth','role:dpa'])->group(function(){
    Route::resource('mahasiswa', \App\Http\Controllers\MahasiswaController::class);
    Route::resource('dosen', \App\Http\Controllers\DosenController::class);
    Route::get('/admin/laporan', [\App\Http\Controllers\LaporanController::class,'index'])->name('admin.laporan.index');
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function(){
    Route::resource('laporan', \App\Http\Controllers\LaporanController::class);
    Route::resource('mahasiswa', \App\Http\Controllers\MahasiswaController::class);
    Route::resource('dosen', \App\Http\Controllers\DosenController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Hanya mahasiswa yang bisa membuat laporan
Route::middleware(['auth','role:mahasiswa'])->group(function(){
    Route::resource('laporan', \App\Http\Controllers\LaporanController::class);
});

// Hanya DPA (admin) yang bisa mengelola mahasiswa, dosen, dan melihat semua laporan
Route::middleware(['auth','role:dpa'])->group(function(){
    Route::resource('mahasiswa', \App\Http\Controllers\MahasiswaController::class);
    Route::resource('dosen', \App\Http\Controllers\DosenController::class);
    Route::get('/admin/laporan', [\App\Http\Controllers\LaporanController::class,'index'])->name('admin.laporan.index');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'dpa') {
        $laporans = \App\Models\Laporan::latest()->paginate(10);
    } else {
        $laporans = \App\Models\Laporan::where('mahasiswa_id', $user->id)->latest()->paginate(10);
    }
    return view('dashboard', compact('laporans','user'));
})->middleware(['auth'])->name('dashboard');
