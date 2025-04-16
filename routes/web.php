<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [JobDashboardController::class, 'index'])->name('dashboard.index');
Route::post('/dashboard/cancel/{jobId}', [JobDashboardController::class, 'cancelJob'])->name('dashboard.cancel');
