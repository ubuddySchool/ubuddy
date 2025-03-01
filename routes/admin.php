<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
  
    Route::get('/admin/home', [AdminController::class, 'adminHome'])->name('admin.home');

});
  