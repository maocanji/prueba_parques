<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('principal');
//});Route::get('/', function () {
//    return view('principal');
//});


Route::get('/', [\App\Http\Controllers\pruebaController::class, 'index'])->name('/');
Route::post('store', [\App\Http\Controllers\pruebaController::class, 'store'])->name('guardar.store');
Route::get('confirmar', [\App\Http\Controllers\pruebaController::class, 'confirmar'])->name('confirmar');
Route::post('eliminar', [\App\Http\Controllers\pruebaController::class, 'eliminar'])->name('eliminar');
Route::post('eliminar2', [\App\Http\Controllers\pruebaController::class, 'eliminar2'])->name('eliminar2');
