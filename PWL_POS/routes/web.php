<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;

Route::pattern('id', '[0-9]+');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::post('register', [AuthController::class, 'register'])->name('register.store');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [WelcomeController::class, 'index']);

    Route::middleware(['authorize:ADM'])->group(function () {
        // Fitur Level
        Route::group(['prefix' => 'level'], function() {
            Route::get('/', [LevelController::class, 'index']);
            Route::post('/list', [LevelController::class, 'list']);
            Route::get('/create', [LevelController::class, 'create']);
            Route::post('/', [LevelController::class, 'store']);
            Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
            Route::post('/ajax', [LevelController::class, 'store_ajax']);
            Route::get('/{id}', [LevelController::class, 'show']);
            Route::get('/{id}/edit', [LevelController::class, 'edit']);
            Route::put('/{id}', [LevelController::class, 'update']);
            Route::delete('/{id}', [LevelController::class, 'destroy']);
            Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        });

        // Fitur Data User
        Route::group(['prefix' => 'user'], function () {
            Route::get('/',[UserController::class,'index']);
            Route::post('/list',[UserController::class,'list']); 
            Route::get('/create',[UserController::class,'create']);
            Route::post('/',[UserController::class,'store']);
            Route::get('/create_ajax',[UserController::class,'create_ajax']);
            Route::post('/ajax',[UserController::class,'store_ajax']);
            Route::get('/{id}',[UserController::class,'show']);
            Route::get('/{id}/edit',[UserController::class,'edit']);
            Route::put('/{id}',[UserController::class,'update']);
            Route::delete('/{id}',[UserController::class,'destroy']);
            Route::get('/{id}/edit_ajax', [UserController::class,'edit_ajax']);
            Route::put('/{id}/update_ajax', [UserController::class,'update_ajax']);
            Route::get('/{id}/delete_ajax', [UserController::class,'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [UserController::class,'delete_ajax']);
            Route::get('/import', [UserController::class, 'import']);
            Route::post('/import_ajax', [UserController::class, 'import_ajax']);
            Route::get('/export_template', [UserController::class, 'export_template']);
        });
    });
    
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        // Fitur Kategori
        Route::group(['prefix' => 'kategori'], function() {
            Route::get('/', [KategoriController::class, 'index']);
            Route::post('/list', [KategoriController::class, 'list']);
            Route::get('/create', [KategoriController::class, 'create']);
            Route::post('/', [KategoriController::class, 'store']);
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);
            Route::get('/{id}', [KategoriController::class, 'show']);
            Route::get('/{id}/edit', [KategoriController::class, 'edit']);
            Route::put('/{id}', [KategoriController::class, 'update']);
            Route::delete('/{id}', [KategoriController::class, 'destroy']);
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
        });
        
        // Fitur Barang
        Route::group(['prefix' => 'barang'], function() {
            Route::get('/', [BarangController::class, 'index']);
            Route::post('/list', [BarangController::class, 'list']);
            Route::get('/create', [BarangController::class, 'create']);
            Route::post('/', [BarangController::class, 'store']);
            Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
            Route::post('/ajax', [BarangController::class, 'store_ajax']);
            Route::get('/{id}', [BarangController::class, 'show']);
            Route::get('/{id}/edit', [BarangController::class, 'edit']);
            Route::put('/{id}', [BarangController::class, 'update']);
            Route::delete('/{id}', [BarangController::class, 'destroy']);
            Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
            Route::get('/import', [BarangController::class, 'import']);
            Route::post('/import_ajax', [BarangController::class, 'import_ajax']);
            Route::get('/export_excel', [BarangController::class, 'export_excel']);
            Route::get('/export_pdf', [BarangController::class, 'export_pdf']);
        });

        // Fitur Supplier
        Route::group(['prefix' => 'supplier'], function() {
            Route::get('/', [SupplierController::class, 'index']);
            Route::post('/list', [SupplierController::class, 'list']);
            Route::get('/create', [SupplierController::class, 'create']);
            Route::post('/', [SupplierController::class, 'store']);
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);
            Route::get('/{id}', [SupplierController::class, 'show']);
            Route::get('/{id}/edit', [SupplierController::class, 'edit']);
            Route::put('/{id}', [SupplierController::class, 'update']);
            Route::delete('/{id}', [SupplierController::class, 'destroy']);
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
            Route::get('/import', [SupplierController::class, 'import']);
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']);
            Route::get('/export_template', [SupplierController::class, 'export_template']);
        });
    });

    Route::group(['prefix' => 'stok', 'middleware' => 'auth'], function() {
        Route::get('/', [StokController::class, 'index']);
        Route::post('/list', [StokController::class, 'list']);
        
        Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
            Route::get('/create_ajax', [StokController::class, 'create_ajax']);
            Route::post('/ajax', [StokController::class, 'store_ajax']);
            Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
            Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
            Route::get('/export_pdf', [StokController::class, 'export_pdf']);
        });
        
        Route::post('/add-to-cart', [StokController::class, 'addToCart']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/cart', [StokController::class, 'viewCart']);
        Route::post('/update-cart', [StokController::class, 'updateCart']);
        Route::post('/remove-from-cart', [StokController::class, 'removeFromCart']);
    });
    
    Route::get('/penjualan', [PenjualanController::class, 'index']);
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);
    Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']);
    
    Route::get('/checkout', [PenjualanController::class, 'checkout']);
    Route::post('/checkout/process', [PenjualanController::class, 'process']);
    
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::post('/penjualan/list', [PenjualanController::class, 'list']);
        Route::get('/penjualan/create', [PenjualanController::class, 'create']);
        Route::post('/penjualan', [PenjualanController::class, 'store']);
    });
});