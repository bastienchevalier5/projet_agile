<?php

declare(strict_types=1);

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'langue'])->group(function () {
    Route::get('/', [AcceuilController::class, 'index'])->name('accueil');

    Route::resource('motif', MotifController::class);

    Route::resource('absence', AbsenceController::class);

    Route::patch('absence/{absence}/validate', [AbsenceController::class, 'validateAbsence'])->name('absence.validate');

    Route::resource('user', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('langue/{langue}', [LanguageController::class, 'switchLang'])->name('lang.switch');
});

require __DIR__.'/auth.php';
