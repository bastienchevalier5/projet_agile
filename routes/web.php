<?php

declare(strict_types=1);

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\AcceuilController;
use App\Http\Controllers\JoursSensiblesController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MotifController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\JoursSensibles;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'langue'])->group(function () {
    Route::get('/', [AcceuilController::class, 'index'])->name('accueil');

    Route::resource('motif', MotifController::class);

    Route::resource('absence', AbsenceController::class);
    Route::get('absence/{user}/planning', [AbsenceController::class, 'userPlanning'])->name('absence.userplanning');
    Route::get('allplanning', [AbsenceController::class, 'allPlanning'])->name('allplanning');
    Route::resource('joursSensibles', JoursSensiblesController::class);

    Route::patch('absence/{absence}/validate', [AbsenceController::class, 'validateAbsence'])->name('absence.validate');
    Route::patch('absences/{absence}/refuse', [AbsenceController::class, 'refuseAbsence'])->name('absence.refuse');
    Route::get('absences/refusees', [AbsenceController::class, 'historiqueRefusees'])->name('absence.refusees');


    Route::resource('user', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('langue/{langue}', [LanguageController::class, 'switchLang'])->name('lang.switch');
});

require __DIR__.'/auth.php';
