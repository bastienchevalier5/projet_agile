<?php
use App\Http\Controllers\MotifController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AcceuilController::class, 'index'])->name('acceuil');


Route::get('motif',[MotifController::class,'index'])->name('motif');
