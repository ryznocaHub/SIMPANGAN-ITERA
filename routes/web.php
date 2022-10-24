<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\ProcurementAccountController;
use App\Http\Controllers\ProcurementItemController;
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;
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

Route::get('/cek', [DashboardController::class, 'cek'])->name('cek');

Route::group(['middleware' => 'auth'], function (){
    // Route::get('/', [DashboardController::class, 'cek'])->name('dashboard.TimHPS');
    
    Route::prefix('admin')->middleware('headUKPBJ')->name('admin.')->group(function(){
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index']);
        Route::get('/dashboard',                [DashboardController::class, 'headUKPBJ'])->name('dashboard');
    });

    Route::prefix('unit')->middleware('unit')->name('unit.')->group(function(){
        Route::resource('procurement',          ProcurementAccountController::class)->except(['destroy']);
        Route::get('procurement/reupload/{id}', [ProcurementAccountController::class,'reUploadRAB'])->name('procurement.reupload');
        Route::patch('procurement/editinfo/{id}', [ProcurementAccountController::class,'editDataRAB'])->name('procurement.editinfo');
        Route::patch('procurement/edititem/{id}', [ProcurementAccountController::class,'editItemRAB'])->name('procurement.edititem');
        Route::resource('item',                 ProcurementItemController::class)->only(['update']);
        Route::get('/dashboard',                [DashboardController::class, 'unit'])->name('dashboard');
    });
    
    Route::prefix('hps')->middleware('hps')->name('hps.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'hps'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update', 'edit']);
        Route::post('updatehps/{id}',           [ProcurementItemController::class, 'updateHPS'])->name('item.updateHPS');
        Route::get('boq/{id}',                  [DocumentsController::class, 'boq'])->name('document.boq');
        Route::get('hps/{id}',                  [DocumentsController::class, 'hps'])->name('document.hps');
    });
    
    Route::prefix('ppk')->middleware('ppk')->name('ppk.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'ppk'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update']);
        Route::get('boq/{id}',                  [DocumentsController::class, 'boq'])->name('document.boq');
        Route::get('hps/{id}',                  [DocumentsController::class, 'hps'])->name('document.hps');
    });
    
    Route::prefix('pp')->middleware('pp')->name('pp.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'pp'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update']);
        Route::get('boq/{id}',                  [DocumentsController::class, 'boq'])->name('document.boq');
        // Route::resource('supplier',             Supplier::class)                    ->only(['create','store']);
    });
    
    Route::prefix('kontrak')->middleware('kontrak')->name('kontrak.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'kontrak'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update']);
        Route::resource('supplier',             SupplierController::class);
        Route::get('boq/{id}',                  [DocumentsController::class, 'boq'])->name('document.boq');
        Route::get('spk/{id}',                  [DocumentsController::class, 'spk'])->name('document.spk');
        Route::get('sppbj/{id}',                [DocumentsController::class, 'sppbj'])->name('document.sppbj');
        Route::get('bastp/{id}',                [DocumentsController::class, 'bastp'])->name('document.bastp');
        Route::get('bap/{id}',                  [DocumentsController::class, 'bap'])->name('document.bap');
        Route::get('sp/{id}',                   [DocumentsController::class, 'sp'])->name('document.sp');
        Route::get('bahp/{id}',                 [DocumentsController::class, 'bahp'])->name('document.bahp');
    });
    
    Route::prefix('siren')->middleware('siren')->name('siren.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'siren'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update']);
    });
    
    Route::resource('item',ProcurementItemController::class)->only(['show']);
    Route::get('/dashboard/TimHPS',             [DashboardController::class, 'TimHPS'])->name('dashboard.TimHPS');
});



require __DIR__.'/auth.php';
