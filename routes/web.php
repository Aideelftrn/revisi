<?php

use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PembelianSampahController;
use App\Http\Controllers\PengepulController;
use App\Http\Controllers\PenyetoranSampahController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\PenarikanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/register', [NasabahController::class, 'registerAkunNasabah'])->name('register.nasabah');
Route::post('/registrasiOffline', [NasabahController::class, 'registerNasabahStore'])->name('registrasi.registerNasabahStore');


Route::middleware(Authenticate::class)->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user', UserController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('nasabah', NasabahController::class);
    Route::resource('pengepul', PengepulController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('penyetoran', PenyetoranSampahController::class);
    Route::resource('sampah', SampahController::class);
    Route::get('/pembelian', [PembelianSampahController::class, 'index'])->name('pembelian.index');
    Route::post('/pembelian/store', [PembelianSampahController::class, 'store'])->name('pembelian.store');
    Route::get('nasabah/{id}/saldo', [NasabahController::class, 'showSaldo'])->name('nasabah.saldo');
    Route::post('nasabah/tarik-saldo', [NasabahController::class, 'tarikSaldo'])->name('nasabah.tarikSaldo');
    Route::get('/nasabah/{id}/riwayat-penarikan', [NasabahController::class, 'riwayatPenarikan'])->name('nasabah.riwayatPenarikan');

    Route::get('/penarikan/approval', [PenarikanController::class, 'approval'])->name('penarikan.approval');
    Route::post('/penarikan/{id}/approve', [PenarikanController::class, 'approve'])->name('penarikan.approve');
    Route::delete('/penarikan/{id}/reject', [PenarikanController::class, 'reject'])->name('penarikan.reject');

    Route::get('pengepul/{id}/topup', [PengepulController::class, 'showTopUpForm'])->name('pengepul.topup.form');
    Route::post('pengepul/{id}/topup', [PengepulController::class, 'topUp'])->name('pengepul.topup');
    Route::get('/pengepul/{id}/riwayat-topup', [PengepulController::class, 'riwayatTopup'])->name('pengepul.riwayatTopup');

    Route::get('/topups', [PengepulController::class, 'indexTopups'])->name('pengepul.topups');
    Route::get('/topups/{id}/approve', [PengepulController::class, 'approveTopup'])->name('pengepul.topups.approve');
    Route::get('/topups/{id}/reject', [PengepulController::class, 'rejectTopup'])->name('pengepul.topups.reject');


    Route::get('/laporan', [TransaksiController::class, 'laporanIndex'])->name('transaksi.laporanIndex');
    Route::get('/laporan/pdf', [TransaksiController::class, 'generatePdf'])->name('transaksi.generatePdf');


    Route::get('/penyetoran/{id}', [PenyetoranSampahController::class, 'show'])->name('penyetoran.detail');

    Route::get('/pembelian/{id}', [PembelianSampahController::class, 'show'])->name('pembelian.show');


    Route::get('/akun/create', [ProfilController::class, 'createAkun'])->name('profil.createAkun');
    Route::post('/akun/store', [ProfilController::class, 'storeAkun'])->name('profil.storeAkun');
});

Route::get('auth/redirect/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('logout', function () {
    Auth::logout();
    return redirect('/login');
});

Auth::routes([
    'register' => false
]);
