<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran');
Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('store.pendaftaran');
Route::put('/pendaftaran/{id}/update', [PendaftaranController::class, 'update'])->name('update.pendaftaran');
Route::delete('/pendaftaran/{id}/delete', [PendaftaranController::class, 'destroy'])->name('delete.pendaftaran');

Route::get('/tindakan', [TindakanController::class, 'index'])->name('tindakan');
Route::post('/tindakan/store', [TindakanController::class, 'store'])->name('store.tindakan');
Route::put('/tindakan/{id}/update', [TindakanController::class, 'update'])->name('update.tindakan');
Route::delete('/tindakan/{id}/delete', [TindakanController::class, 'destroy'])->name('delete.tindakan');

Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran');
Route::post('/pengeluaran/post', [PengeluaranController::class, 'store'])->name('store.pengeluaran');
Route::put('/pengeluaran/{id}/update', [PengeluaranController::class, 'update'])->name('update.pengeluaran');
Route::delete('/pengeluaran/{id}/delete', [PengeluaranController::class, 'destroy'])->name('delete.pengeluaran');

Route::get('/opsi_tindakan', [OpsiTindakanController::class, 'index'])->name('opsi_tindakan');
Route::post('/opsi_tindakan/store', [OpsiTindakanController::class, 'store'])->name('store.opsi_tindakan');
Route::put('/opsi_tindakan/{id}/update', [OpsiTindakanController::class, 'update'])->name('update.opsi_tindakan');
Route::delete('/opsi_tindakan/{id}/delete', [OpsiTindakanController::class, 'destroy'])->name('delete.opsi_tindakan');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');
Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
