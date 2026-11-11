<?php

use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProgramController::class, 'index'])->name('home');

Route::resource('programs', ProgramController::class)
    ->only(['index', 'store', 'edit', 'update', 'destroy']);
