<?php
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AcceuilController::class, 'index'])->name('acceuil');


Route::get('motif',[MotifController::class,'index'])->name('motif');

Route::get('absence/{a}',[AbsenceController::class,'show'])->name('absence');

Route::get('user/{a}',[UserController::class,'show'])->name('absence_user');
