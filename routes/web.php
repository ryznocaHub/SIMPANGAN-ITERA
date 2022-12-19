<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\ProcurementAccountController;
use App\Http\Controllers\ProcurementItemController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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


Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


Route::group(['middleware' => 'auth'], function (){
    
    Route::prefix('admin')->middleware('admin')->name('admin.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'headUKPBJ'])->name('dashboard');
        Route::get('user/nonactive',            [UserController::class, 'usersNonActive']) ->name('usersNonActive');
        Route::post('user/nonactiveuser/{id}',  [UserController::class, 'nonActiveUser'])  ->name('nonActiveUser');
        Route::post('user/activeuser/{id}',     [UserController::class, 'activeUser'])     ->name('activeUser');
        Route::resource('user',                 UserController::class)->except(['show']);
        // Route::resource('supplier',             SupplierController::class)->only(['index', 'show']);
        Route::resource('procurement',          ProcurementAccountController::class)->only(['show','index']);
    });

    Route::prefix('unit')->middleware('unit')->name('unit.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'unit'])->name('dashboard');
        Route::get('procurement/reupload/{id}', [ProcurementAccountController::class,'reUploadRAB'])->name('procurement.reupload');
        Route::patch('procurement/editinfo/{id}', [ProcurementAccountController::class,'editDataRAB'])->name('procurement.editinfo');
        Route::patch('procurement/edititem/{id}', [ProcurementAccountController::class,'editItemRAB'])->name('procurement.edititem');
        Route::resource('item',                 ProcurementItemController::class)->only(['update']);
        Route::resource('procurement',          ProcurementAccountController::class)->except(['destroy']);
    });
    
    Route::prefix('hps')->middleware('hps')->name('hps.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'hps'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update', 'edit']);
        Route::post('updatehps/{id}',           [ProcurementItemController::class, 'updateHPS'])->name('item.updateHPS');
        Route::get('boq/{id}',                  [DocumentsController::class, 'boq'])->name('document.boq');
        Route::patch('document/hps/{id}',       [DocumentsController::class, 'fisikhps'])->name('fisik.hps');
        Route::get('hps/{id}',                  [DocumentsController::class, 'hps'])->name('document.hps');
        Route::get('item/{name}',               [ProcurementItemController::class, 'list'])->name('item.list');
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
        Route::get('bakn/{id}',                 [DocumentsController::class, 'bakn'])->name('document.bakn');
        Route::get('bahp/{id}',                 [DocumentsController::class, 'bahp'])->name('document.bahp');
        Route::get('bae/{id}',                  [DocumentsController::class, 'baep'])->name('document.baep');
        // Route::resource('supplier',             Supplier::class)                    ->only(['create','store']);
    });
    
    Route::prefix('kontrak')->middleware('kontrak')->name('kontrak.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'kontrak'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update']);
        Route::get('boq/{id}',                  [DocumentsController::class, 'boq'])->name('document.boq');
        Route::get('spk/{id}',                  [DocumentsController::class, 'spk'])->name('document.spk');
        Route::get('sppbj/{id}',                [DocumentsController::class, 'sppbj'])->name('document.sppbj');
        Route::get('bastp/{id}',                [DocumentsController::class, 'bastp'])->name('document.bastp');
        Route::get('bap/{id}',                  [DocumentsController::class, 'bap'])->name('document.bap');
        Route::get('bp/{id}',                   [DocumentsController::class, 'bp'])->name('document.bp');
        Route::get('sp/{id}',                   [DocumentsController::class, 'sp'])->name('document.sp');
    });
    
    Route::prefix('siren')->middleware('siren')->name('siren.')->group(function(){
        Route::get('/dashboard',                [DashboardController::class, 'siren'])->name('dashboard');
        Route::resource('procurement',          ProcurementAccountController::class)->only(['index', 'show', 'update']);
    });
    
    Route::resource('supplier',                 SupplierController::class);
    Route::resource('item',                     ProcurementItemController::class)->only(['show']);
    Route::get('/dashboard/TimHPS',             [DashboardController::class, 'TimHPS'])->name('dashboard.TimHPS');
    Route::resource('actor',                    UserController::class)->only(['show','edit','update']);
});



require __DIR__.'/auth.php';
