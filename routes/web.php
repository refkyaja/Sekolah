<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AkademikController;
use App\Http\Controllers\SaranaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PPDBController;

// 1. Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

// 3. Galeri
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// 4. Profil Sekolah
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/sejarah', function () { return view('profil.sejarah'); })->name('sejarah');
    Route::get('/sambutan', function () { return view('profil.sambutan'); })->name('sambutan');
    Route::get('/visi-misi', function () { return view('profil.visimisi'); })->name('visimisi');
    Route::get('/program', function () { return view('profil.program'); })->name('program');
    Route::get('/lokasi', function () { return view('profil.lokasi'); })->name('lokasi');
});

// 5. Akademik
Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('/kegiatan', function () { return view('akademik.kegiatan'); })->name('kegiatan');
    Route::get('/prestasi', function () { return view('akademik.prestasi'); })->name('prestasi');
    Route::get('/ekstrakurikuler', function () { return view('akademik.ekstrakurikuler'); })->name('ekstrakurikuler');
    Route::get('/bahan-ajar', function () { return view('akademik.bahan-ajar'); })->name('bahan-ajar');
});

// 6. Sarana & Prasarana
Route::prefix('sarana')->name('sarana.')->group(function () {
    Route::get('/infrastruktur', function () { return view('sarana.infrastruktur'); })->name('infrastruktur');
    Route::get('/pembelajaran', function () { return view('sarana.pembelajaran'); })->name('pembelajaran');
});

// 7. Layanan
Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/buku-tamu', function () { return view('layanan.buku-tamu'); })->name('buku-tamu');
    Route::get('/kontak', function () { return view('layanan.kontak'); })->name('kontak');
});

// 8. PPDB
Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', [PPDBController::class, 'index'])->name('index');
    Route::post('/', [PPDBController::class, 'store'])->name('store');
    Route::get('/success', [PPDBController::class, 'success'])->name('success');
});

// routes/web.php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('berita', Admin\BeritaController::class);
});