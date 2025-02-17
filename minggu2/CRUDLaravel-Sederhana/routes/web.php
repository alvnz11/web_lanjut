<?php // Tag pembuka PHP

use Illuminate\Support\Facades\Route; // Mengimpor fasad Route untuk mendefinisikan rute
use App\Http\Controllers\ItemController; // Mengimport ItemController
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () { // Mendefinisikan route untuk halaman utama (root)
    return view('welcome'); // Mengembalikan tampilan 'welcome' di view welcome.blade.php
});

Route::resource('items', ItemController::class); // Membuat route resource (CRUD) dengan controller ItemController 
