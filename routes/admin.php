<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
  
    Route::get('/admin/home', [AdminController::class, 'adminHome'])->name('admin.home');
    Route::get('/admin/crm', [AdminController::class, 'crm'])->name('admin.crm');
    Route::get('/admin/follow_up', [AdminController::class, 'follow_up'])->name('follow_up.admin');
    Route::get('/admin/pending_request', [AdminController::class, 'pending_request'])->name('pending_request');
    Route::post('/update-visit-status', [AdminController::class, 'updateVisitStatus'])->name('update-visit-status');
    Route::get('admin/expired_follow_up', [AdminController::class, 'admin_expired_follow_up'])->name('admin.expired_follow_up');
    Route::get('admin/visit_record', [AdminController::class, 'admin_visit_record'])->name('admin.visit_record');
    Route::get('admin/assing_crm', [AdminController::class, 'assing_crm'])->name('admin.assin.crm');
    
    // view details
    Route::get('admin/view/details/{id}', [AdminController::class, 'view_details'])->name('admin.view.details');
    Route::put('/admin/enquiry/{id}/update-crm', [AdminController::class, 'updateCrm'])->name('admin.enquiry.update_crm');


});
  