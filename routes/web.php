<?php

use App\Http\Controllers\AbsensiKaryawanController;
use App\Http\Controllers\AbsensiToken;
use App\Http\Controllers\AbsensiTokenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaruController;
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

Route::get('/token', [AbsensiTokenController::class, 'index']);
Route::get('/get-newtoken', [AbsensiToken::class, 'index']);
Route::get('/get-absensi', [AbsensiKaryawanController::class, 'index']);
Route::get('/karu', [KaruController::class, 'index'])->middleware('authapi');
Route::get('/karu/absensi-hari-ini', [KaruController::class, 'today'])->middleware('authapi');
Route::get('/karu/log-karyawan', [KaruController::class, 'logKaryawan'])->middleware('authapi');
Route::get('/karu/shift', [KaruController::class, 'shift'])->middleware('authapi');
Route::get('/karu/jadwal', [KaruController::class, 'jadwal'])->middleware('authapi');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login-auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('authapi');


Route::get('/dev', function () {
    dd(session('key'));
});
