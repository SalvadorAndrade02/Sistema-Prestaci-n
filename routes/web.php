<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TablaEjemploController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PrestamoController;

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/fetch-table-data', [TablaEjemploController::class, 'fetchTableData']); */
Route::get('/prestamos', [PrestamoController::class, 'index', 'fetchTableData']);
Route::get('/get-tools/{table}', [TableController::class, 'getTools']);
Route::get('/get-quantity/{table}/{tool}', [TableController::class, 'getQuantity']);
Route::post('/update-quantity', [TableController::class, 'updateQuantity']);

Route::get('/dashboard', [PrestamoController::class, 'index'], function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Define la ruta que llama al método index del controlador

require __DIR__.'/auth.php';
