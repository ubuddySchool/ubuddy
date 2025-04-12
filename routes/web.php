<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnquiryController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

if (file_exists($adminRoutes = __DIR__.'/admin.php')) {
    require $adminRoutes;
}


Route::get('clear-cache', function () {
         Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('migrate');
        return 'Cache cleared and migrations run!';
});


Route::get('run-migrations', function () {
    Artisan::call('migrate');
    return 'Migrations completed!';
});

Route::get('refresh-migrations', function () {
    Artisan::call('migrate:refresh');
    return 'Migrations refreshed!';
});


Route::get('run-seeders', function () {
    Artisan::call('db:seed');
    return 'Seeders have been run!';
});

Route::get('reset-migrations', function () {
    Artisan::call('migrate:reset');
    return 'Migrations have been reset!';
});

Route::get('test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

Route::get('/get-location/{pincode}', function ($pincode) {
    $response = Http::get("http://www.postalpincode.in/api/pincode/{$pincode}");
    
    if ($response->successful()) {
        return response()->json($response->json());
    } else {
        return response()->json(['Status' => 'Error', 'Message' => 'API Failed'], 500);
    }
});


Auth::routes();



Route::middleware(['auth', 'user-access:employee'])->group(function () {
  
    // Route::get('/home', action: [HomeController::class,0 'index'])->name('home');
    Route::get('/add', action: [EnquiryController::class, 'add'])->name('enquiry.add');
    Route::post('/store', action: [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::get(uri: '/edit/{id}', action: [EnquiryController::class, 'edit'])->name('enquiry.edit');
    Route::post('/update/{id}', action: [EnquiryController::class, 'update'])->name('enquiry.update');
    
    Route::get('/poclist', [HomeController::class, 'poclist'])->name('poclist');
    Route::post('/update-poc/{id}', [HomeController::class, 'update'])->name('update.poc');
    
    // enquires followup last date
    Route::get('/home', [HomeController::class, 'last_follow'])->name('home');

    Route::get('/enquiry/{id}', [HomeController::class, 'show'])->name('enquiry.show');
    Route::get('/follow_up', [HomeController::class, 'follow_up'])->name('follow_up');
    Route::get('/expired_follow_up', [HomeController::class, 'expired_follow_up'])->name('expired_follow_up');
    Route::get('/visit_record', [HomeController::class, 'visit_record'])->name('visit_record');
    Route::post('/update-remark/{id}', [HomeController::class, 'updateRemark'])->name('update.remark');
    Route::post('/addpocs/{id}', [EnquiryController::class, 'addpocs'])->name('add.pocs');
    Route::post('/addvisit/{id}', [EnquiryController::class, 'addvisit'])->name('add.visit');

});

// Route::resource('enquiries', EnquiryController::class);

// Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
  
//     Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
// });
  