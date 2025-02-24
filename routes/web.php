<?php

use App\Http\Controllers\{
    NasabahController,
    PengepulController,
    PenyetoranSampahController,
    ProfilController,
    SampahController,
    TransaksiController,
    GoogleController,
    UserController,
    PenarikanController,
    PenjualanSampahController,
    HomeController
};
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\{Route, Auth};

// Registrasi Nasabah
Route::get('/register', [NasabahController::class, 'registerAkunNasabah'])->name('register.nasabah');
Route::post('/registrasiOffline', [NasabahController::class, 'registerNasabahStore'])->name('registrasi.registerNasabahStore');

// Middleware Authentication
Route::middleware(Authenticate::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index']);

    Route::resources([
        'user' => UserController::class,
        'profil' => ProfilController::class,
        'nasabah' => NasabahController::class,
        'pengepul' => PengepulController::class,
        'transaksi' => TransaksiController::class,
        'penyetoran' => PenyetoranSampahController::class,
        'sampah' => SampahController::class,
    ]);

    // Penjualan Sampah
    Route::prefix('penjualan')->group(function () {
        Route::get('/', [PenjualanSampahController::class, 'index'])->name('penjualan.index');
        Route::post('/jual', [PenjualanSampahController::class, 'jual'])->name('penjualan.jual');
        Route::get('/{id}', [PenjualanSampahController::class, 'show'])->name('penjualan.show');
        Route::delete('/cancel/{id}', [PenjualanSampahController::class, 'cancel'])->name('penjualan.cancel');
        Route::post('/jualSemua', [PenjualanSampahController::class, 'jualSemua'])->name('penjualan.jualSemua');
    });

    // Nasabah
    Route::prefix('nasabah')->group(function () {
        Route::get('{id}/saldo', [NasabahController::class, 'showSaldo'])->name('nasabah.saldo');
        Route::post('tarik-saldo', [NasabahController::class, 'tarikSaldo'])->name('nasabah.tarikSaldo');
        Route::get('{id}/riwayat-penarikan', [NasabahController::class, 'riwayatPenarikan'])->name('nasabah.riwayatPenarikan');
    });

    // Penarikan
    Route::prefix('penarikan')->group(function () {
        Route::get('/approval', [PenarikanController::class, 'approval'])->name('penarikan.approval');
        Route::post('{id}/approve', [PenarikanController::class, 'approve'])->name('penarikan.approve');
        Route::delete('{id}/reject', [PenarikanController::class, 'reject'])->name('penarikan.reject');
    });

    // Pengepul & Topup
    Route::prefix('pengepul')->group(function () {
        Route::get('{id}/topup', [PengepulController::class, 'showTopUpForm'])->name('pengepul.topup.form');
        Route::post('{id}/topup', [PengepulController::class, 'topUp'])->name('pengepul.topup');
        Route::get('{id}/riwayat-topup', [PengepulController::class, 'riwayatTopup'])->name('pengepul.riwayatTopup');
    });
    Route::prefix('topups')->group(function () {
        Route::get('/', [PengepulController::class, 'indexTopups'])->name('pengepul.topups');
        Route::get('{id}/approve', [PengepulController::class, 'approveTopup'])->name('pengepul.topups.approve');
        Route::get('{id}/reject', [PengepulController::class, 'rejectTopup'])->name('pengepul.topups.reject');
    });

    // Laporan Transaksi
    Route::prefix('laporan')->group(function () {
        Route::get('/', [TransaksiController::class, 'laporanIndex'])->name('transaksi.laporanIndex');
        Route::get('/pdf', [TransaksiController::class, 'generatePdf'])->name('transaksi.generatePdf');
    });

    // Profil & Akun
    Route::prefix('akun')->group(function () {
        Route::get('/create', [ProfilController::class, 'createAkun'])->name('profil.createAkun');
        Route::post('/store', [ProfilController::class, 'storeAkun'])->name('profil.storeAkun');
    });
});

// Google Authentication
Route::get('auth/redirect/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Logout
Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
});

// Authentication Routes
Auth::routes(['register' => false]);
