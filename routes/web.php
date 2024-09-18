<?php
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',[AcceuilController::class,'index'])->name('acceuil');


Route::resource('motif',MotifController::class);

Route::resource('absence',AbsenceController::class);

Route::get('user/{a}',[UserController::class,'show'])->name('absence_user');
