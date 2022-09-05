<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProcurementAccountController;
use App\Http\Controllers\ProcurementItemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::group(['middleware' => 'auth'], function (){
    // Route::get('/', [DashboardController::class, 'cek'])->name('dashboard.TimHPS');
    
    Route::group(['middleware' => 'unit', 'prefix' => 'unit'],function(){
        Route::resource('procurement',          ProcurementAccountController::class)->except('destroy');
        Route::get('/dashboard',                [DashboardController::class, 'unit'])->name('dashboard.unit');
    });
    
    Route::group(['middleware' => 'headUKPBJ', 'prefix' => 'admin'],function(){
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index']);
        Route::get('/dashboard',                [DashboardController::class, 'headUKPBJ'])->name('dashboard.unit');
    });
    
    Route::group(['middleware' => 'hps', 'prefix' => 'hps'],function(){
        
    });

    Route::post('/procurement/updatestatus/{id}', [ProcurementAccountController::class, 'updateStatus'])->name('procurement.updatestatus');
    Route::get('/dashboard/TimHPS', [DashboardController::class, 'TimHPS'])->name('dashboard.TimHPS');
    Route::resource('item',ProcurementItemController::class);
});



require __DIR__.'/auth.php';
