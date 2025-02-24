<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
  
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});
  