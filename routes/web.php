<?php

use App\Http\Controllers\AbsensiKaryawanController;
use App\Http\Controllers\AbsensiToken;
use App\Http\Controllers\AbsensiTokenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\KaruController;
use App\Http\Controllers\WasinController;
use App\Http\Controllers\ClaimRujukanController;
use App\Exports\AbsensiExport;
use App\Exports\BulananExport;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\ESurveyController;
use App\Http\Controllers\LaporanFarmasiController;
use App\Http\Controllers\LaporanRajalController;
use App\Http\Controllers\PasienController;
use Maatwebsite\Excel\Facades\Excel;




use App\Http\Controllers\SalaryController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/token', [AbsensiTokenController::class, 'index'])->middleware('authapi')->name('token_page');
Route::get('/get-newtoken', [AbsensiToken::class, 'index']);
Route::get('/get-absensi', [AbsensiKaryawanController::class, 'index']);

// Karu -------------------------- Karu
Route::get('/karu', [KaruController::class, 'index'])->middleware('authapi');
Route::get('/karu/absensi-hari-ini', [KaruController::class, 'today'])->middleware('authapi');
Route::get('/karu/log-karyawan', [KaruController::class, 'logKaryawan'])->middleware('authapi');
// Shift
Route::get('/karu/shift', [KaruController::class, 'shift'])->middleware('authapi');
Route::post('/karu/save-shift', [KaruController::class, 'storeShift'])->middleware('authapi');
Route::get('/karu/delete-shift/{id}', [KaruController::class, 'deleteShift'])->middleware('authapi')->name('delete_shift');
// Jadwal
Route::get('/karu/jadwal/{month}', [KaruController::class, 'jadwal'])->middleware('authapi');
Route::post('/karu/jadwal', [KaruController::class, 'storeUserShift'])->middleware('authapi');
Route::delete('/karu/jadwal', [KaruController::class, 'deleteUserShift'])->middleware('authapi');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login-auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('authapi');

// Admin --------------------------- Admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('authapi');
Route::get('/admin/unit', [AdminController::class, 'unit'])->middleware('authapi');
Route::get('/admin/unit/{id}', [AdminController::class, 'unitDetail'])->middleware('authapi');
Route::post('/admin/unit/{id}', [AdminController::class, 'unitDetailAdd']);
Route::get('/admin/users', [AdminController::class, 'users'])->middleware('authapi');
Route::get('/admin/users/{id}', [AdminController::class, 'users'])->middleware('authapi');

// Admin API
Route::get('/admin/api/karyawan/{filter}', [AdminController::class, 'karyawan']);

//wasin
Route::get('/wasin', [WasinController::class, 'index'])->middleware('authapi');
Route::get('/wasin/cuti', [WasinController::class, 'laporan_cuti'])->middleware('authapi');
Route::get('/wasin/izin', [WasinController::class, 'laporan_izin'])->middleware('authapi');
Route::get('/wasin/laporan', [WasinController::class, 'absensi_laporan'])->middleware('authapi');
Route::get('/wasinexport', [WasinController::class, 'exportLaporan'])->middleware('authapi');
Route::get('/wasin/harian', [WasinController::class, 'absensi_harian'])->middleware('authapi');
Route::get('/change', [WasinController::class, 'index'])->name('change')->middleware('authapi');
Route::get('/absen_unit', [WasinController::class, 'absensi_harian'])->name('absen_unit')->middleware('authapi');
Route::get('/export-absensi', [WasinController::class, 'exportHarian'])->name('export_absensi')->middleware('authapi');
Route::get('/absensi-laporan', [WasinController::class, 'absensi_laporan'])->name('absensi_laporan')->middleware('authapi');
Route::get('/absensi-export', [WasinController::class, 'exportLaporan'])->name('absensi_export');
Route::get('/filter_absensi', [WasinController::class, 'filterAbsensi'])->name('filter_absensi')->middleware('authapi');





// Keuangan ------------------------- Keuangan
Route::get('/keuangan', [SalaryController::class, 'index'])->middleware('authapi')->name('data-slip-gaji');
Route::post('/keuangan', [ExcelImportController::class, 'import'])->middleware('authapi')->name('import-excel');
Route::get('/keuangan/baru', [SalaryController::class, 'baru'])->middleware('authapi')->name('gaji-baru');
Route::get('/keuangan/baru/activate', [SalaryController::class, 'activateBaru'])->middleware('authapi')->name('aktifkan-gaji-baru');

// Klaim Rujukan
Route::get('/klaim-rujukan', [ClaimRujukanController::class, 'index'])->middleware('authapi');
Route::get('/detail-klaim-rujukan', [ClaimRujukanController::class, 'detailDataRujukan'])->middleware('authapi');
Route::get('/klaim-rujukan/verif/{id}', [ClaimRujukanController::class, 'verif'])->middleware('authapi')->name('klaim-rujukan-verif');
Route::get('/klaim-rujukan/cetak/{id}', [ClaimRujukanController::class, 'print'])->middleware('authapi')->name('klaim-rujukan-cetak');

// Esurvey ------------------------- Esurvey
Route::get('/karu/esurvey-bulan-ini', [ESurveyController::class, 'unit'])->middleware('authapi');
Route::get('/karu/esurvey-bulan-ini/{unit_id}', [ESurveyController::class, 'unit'])->middleware('authapi');
Route::get('/karu/esurvey-jenis-karyawan', [ESurveyController::class, 'jenisKaryawan'])->middleware('authapi');
Route::get('/karu/esurvey-jenis-karyawan/{jenis_karyawan_id}', [ESurveyController::class, 'jenisKaryawan'])->middleware('authapi');
Route::get('/karu/esurvey/delete/{id}', [ESurveyController::class, 'deleteEsurvey'])->middleware('authapi');

// Laporan ------------------------ Laporan
Route::get('/laporan/rajal', [LaporanRajalController::class, 'index'])->middleware('authapi');
Route::get('/laporan/rajal/bytanggal/{tahun}/{bulan}/{tanggal}', [LaporanRajalController::class, 'byTanggal'])->middleware('authapi');
Route::get('/laporan/farmasi', [LaporanFarmasiController::class, 'index'])->middleware('authapi');

// Pasien ------------------------ Pasien
Route::get('/pasien/cari', [PasienController::class, 'index'])->middleware('authapi');
Route::get('/pasien/penunjang/operasi/{no_rkm_medis}', [PasienController::class, 'operasi'])->middleware('authapi');

// Antrian Poli --------------------- Antrian Poli
Route::get('/antrian/poli', [AntrianController::class, 'index'])->middleware('authapi');

// Coming Soon --------------------- Coming Soon
Route::get('/comingsoon', function() {
    return view('page.coming-soon');
});

Route::get('/dev', function () {
    dd(session('key'));
});
