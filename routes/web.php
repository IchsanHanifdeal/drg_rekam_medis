<?php

use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\OpsiTindakanController;

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

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/profile', [PendaftaranController::class, 'setting'])->name('profile');
    Route::put('/dashboard/profile/{id}/info', [AuthController::class, 'update_info'])->name('update.profile');
    Route::put('/dashboard/profile/{id}/password', [AuthController::class, 'update_password'])->name('update.password');

    Route::get('/dashboard/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');
    Route::post('/dashboard/pendaftaran/store', [PendaftaranController::class, 'store'])->name('store.pendaftaran');
    Route::put('/dashboard/pendaftaran/{id}/update', [PendaftaranController::class, 'update'])->name('update.pendaftaran');
    Route::delete('/dashboard/pendaftaran/{id}/delete', [PendaftaranController::class, 'destroy'])->name('delete.pendaftaran');

    Route::get('/dashboard/tindakan', [TindakanController::class, 'index'])->name('tindakan');
    Route::post('/dashboard/tindakan/store', [TindakanController::class, 'store'])->name('store.tindakan');
    Route::put('/dashboard/tindakan/{id}/update', [TindakanController::class, 'update'])->name('update.tindakan');
    Route::delete('/dashboard/tindakan/{id}/delete', [TindakanController::class, 'destroy'])->name('delete.tindakan');

    Route::get('/dashboard/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
    Route::post('/dashboard/pengeluaran/post', [PengeluaranController::class, 'store'])->name('store.pengeluaran');
    Route::put('/dashboard/pengeluaran/{id}/update', [PengeluaranController::class, 'update'])->name('update.pengeluaran');
    Route::delete('/dashboard/pengeluaran/{id}/delete', [PengeluaranController::class, 'destroy'])->name('delete.pengeluaran');

    Route::get('/dashboard/opsi_tindakan', [OpsiTindakanController::class, 'index'])->name('opsi_tindakan');
    Route::post('/dashboard/opsi_tindakan/store', [OpsiTindakanController::class, 'store'])->name('store.opsi_tindakan');
    Route::put('/dashboard/opsi_tindakan/{id}/update', [OpsiTindakanController::class, 'update'])->name('update.opsi_tindakan');
    Route::delete('/dashboard/opsi_tindakan/{id}/delete', [OpsiTindakanController::class, 'destroy'])->name('delete.opsi_tindakan');

    Route::get('/dashboard/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/dashboard/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    // Untuk mendownload PDF yang sudah dibuat
    Route::get('/dashboard/laporan/download-pdf/{filename}', function ($filename) {
        return view('vendor.download_pdf', ['filename' => $filename]);
    })->name('laporan.download.pdf');
    Route::get('/dashboard/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');

    Route::get('/dashboard/pasien', [PendaftaranController::class, 'pasien'])->name('pasien');
    Route::get('/dashboard/pemasukan/filter', [DashboardController::class, 'filterAjax'])->name('pemasukan.filter.ajax');
});
