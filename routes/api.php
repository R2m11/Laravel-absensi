<?php

use App\Http\Controllers\AbsenKaryawanApiController;
use App\Http\Controllers\LoginApiController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/auth/login', [LoginApiController::class, 'loginUser']);

Route::get('/absenkaryawan/{absenkaryawan}/edit',[AbsenKaryawanApiController::class,'edit']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/absenkaryawan',[AbsenKaryawanApiController::class,'index']);
    Route::post('/absenkaryawan/create',[AbsenKaryawanApiController::class,'create']);
    Route::post('/absenkaryawan',[AbsenKaryawanApiController::class,'store']);
    Route::patch('/absenkaryawan/{absenkaryawan}',[AbsenKaryawanApiController::class,'update']);
    Route::get('/auth/logout', [LoginApiController::class, 'logoutUser']);
});
