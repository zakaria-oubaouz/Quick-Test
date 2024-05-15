<?php

use App\Http\Controllers\CalculatorController;
use Illuminate\Support\Facades\Route;


Route::get('/', [CalculatorController::class, 'index']);
Route::post('/', [CalculatorController::class, 'calculate'])->name('calculate');