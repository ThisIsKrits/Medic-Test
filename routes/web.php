<?php

use App\Http\Controllers\CheckupController;
use App\Http\Controllers\CheckupFileController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PrescriptionDetailController;
use App\Http\Controllers\TypeVitalController;
use App\Http\Controllers\UpdateStatusPrescriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VitalSignController;
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
Route::middleware(['auth'])->get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth','role:superadmin|admin']], function(){
    Route::resource('log-activity', LogController::class);
    Route::resource('user', UserController::class);
});

Route::group(['middleware' => ['auth','role:dokter|superadmin']], function(){
    Route::resource('type-vital', TypeVitalController::class);
    Route::resource('patient', PatientController::class);
});

Route::group(['middleware' => ['auth','role:dokter|superadmin']], function(){
    Route::resource('checkup', CheckupController::class);
    Route::resource('vital-sign', VitalSignController::class);
    Route::resource('checkup-file', CheckupFileController::class);
});


Route::group(['middleware' => ['auth','role:apoteker|superadmin|dokter|admin']], function(){
    Route::resource('medicine', MedicineController::class);
    Route::resource('prescription', PrescriptionController::class);
    Route::resource('prescription-detail', PrescriptionDetailController::class);
    Route::resource('prescription-update', UpdateStatusPrescriptionController::class);
});

Auth::routes();

