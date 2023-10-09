<?php

use App\Http\Controllers\AbsenKaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\GajiHarianController;
use App\Http\Controllers\GajiLemburHarianController;
use App\Http\Controllers\HalamanAwalController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\LemburHarianController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\UserBagianController;
use App\Http\Controllers\XkehadiranController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::middleware(['auth'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('position',PositionController::class)->middleware('admin');
    Route::resource('karyawan',KaryawanController::class)->middleware('admin');
    Route::resource('profile', ProfileController::class)->only('index','update','edit');
    Route::resource('proyek',ProyekController::class);
    Route::resource('jadwal', JadwalController::class)->middleware('admin');
    Route::resource('perusahaan',PerusahaanController::class)->middleware('admin');
    Route::resource('bagian',BagianController::class)->middleware('admin');
    Route::resource('userbagian',UserBagianController::class)->middleware('admin');
    Route::resource('absensi',AbsensiController::class)->middleware('admin');
    Route::resource('kasbon',KasbonController::class)->middleware('admin');
    Route::get('/kehadiran', [KehadiranController::class,'index'])->middleware('admin');
    Route::get('/kehadiran/{kehadiran}/edit', [KehadiranController::class,'edit'])->middleware('admin');
    Route::put('/kehadiran/{kehadiran}',[KehadiranController::class,'update'])->middleware('admin');
    Route::get('/kehadiran/show',[KehadiranController::class,'show'])->middleware('admin');
    Route::delete('/kehadiran/{kehadiran}',[kehadiranController::class,'destroy'])->middleware('admin');
    Route::resource('gajilemburharian',GajiLemburHarianController::class)->middleware('admin');
    Route::resource('gajiharian',GajiHarianController::class)->middleware('admin');
    Route::resource('lemburharian',LemburHarianController::class)->middleware('admin');
    Route::get('/rekap',[RekapController::class,'index'])->name('rekap.index')->middleware('admin');
    Route::get('/rekap/exportexcel',[RekapController::class,'exportexcel'])->name('rekap.export.excel')->middleware('admin');
    Route::get('/tagihan',[TagihanController::class,'index'])->name('tagihan.index')->middleware('admin');
    Route::get('/tagihan/tagihanexcel',[TagihanController::class,'tagihanexcel'])->name('tagihan.export.excel')->middleware('admin');
    Route::get('/xkehadiran',[XkehadiranController::class,'index'])->middleware('admin');
    Route::post('/xkehadiran',[XkehadiranController::class,'store'])->middleware('admin');
    Route::get('/xkehadiran/create',[XkehadiranController::class,'create'])->middleware('admin');
    Route::get('/absenkaryawan',[AbsenKaryawanController::class,'index']);
    Route::post('/absenkaryawan',[AbsenKaryawanController::class,'store']);
    Route::get('/absenkaryawan/create',[AbsenKaryawanController::class,'create']);
    Route::get('/absenkaryawan/{absenkaryawan}/edit',[AbsenKaryawanController::class,'edit']);
    Route::put('/absenkaryawan/{absenkaryawan}',[AbsenKaryawanController::class,'update']);
    Route::get('/absenkaryawan/report',[AbsenKaryawanController::class,'show']);


});

