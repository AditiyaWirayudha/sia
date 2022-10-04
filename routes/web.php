<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    GuruController,
    KelasController,
    MapelController,
    SiswaController,
    DashboardController
};


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
    return view('layout.app');
});

// Route dashboard
Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard.index');

// route Guru
Route::resource('/guru',GuruController::class);

// route Kelas
Route::get('/kelas/data',[KelasController::class, 'data'])->name('kelas.data');
Route::resource('/kelas',KelasController::class);

// Route Mapel
Route::get('/mapel/data',[MapelController::class, 'data'])->name('mapel.data');
Route::resource('/mapel',MapelController::class);

// Route Siswa
Route::resource('/siswa',SiswaController::class);