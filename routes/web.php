<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TablaEjemploController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\ReportController;
use FontLib\Table\Type\name;

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

Route::post('prestaciones.create', [PrestamoController::class, 'create'])->name('prestaciones.create');
Route::put('prestaciones.update {id}', [PrestamoController::class, 'update'])->name('prestaciones.update');
Route::delete('prestaciones.destroy {id}', [PrestamoController::class, 'destroy'])->name('prestaciones.destroy');
Route::get('prestacion-pdf/{id}', [ReportController::class, 'generatePrestaPDF'])->name('prestacion.pdf');
Route::get('report_general', [ReportController::class, 'reporteGeneral'])->name('reporteGeneral.pdf');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Define la ruta que llama al método index del controlador

require __DIR__.'/auth.php';
