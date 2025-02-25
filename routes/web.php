<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnquiryController;

Route::get('/', function () {
    return view('auth.login');
});

if (file_exists($adminRoutes = __DIR__.'/admin.php')) {
    require $adminRoutes;
}
Auth::routes();

Route::middleware(['auth', 'user-access:employee'])->group(function () {
  
    Route::get('/home', action: [HomeController::class, 'index'])->name('home');
    Route::get('/add', action: [EnquiryController::class, 'add'])->name('enquiry.add');
    Route::post('/store', action: [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::get(uri: '/edit/{id}', action: [EnquiryController::class, 'edit'])->name('enquiry.edit');
    Route::post('/update/{id}', action: [EnquiryController::class, 'update'])->name('enquiry.update');
    
});

Route::resource('enquiries', EnquiryController::class);

// Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
  
//     Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
// });
  