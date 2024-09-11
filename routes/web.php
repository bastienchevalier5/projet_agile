<?php
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AcceuilController::class, 'index'])->name('acceuil');

Route::get('{a}', [PagesController::class, 'pages'])->name('page');
