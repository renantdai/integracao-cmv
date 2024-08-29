<?php

use App\Http\Controllers\Admin\CamController;
use App\Http\Controllers\Admin\DirectoryController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::delete('/cams/{id}', [CamController::class, 'destroy'])->name('cams.destroy');
Route::put('/cams/{id}', [CamController::class, 'update'])->name('cams.update');
Route::get('/cams/{id}/edit', [CamController::class, 'edit'])->name('cams.edit');
Route::get('/cams/create', [CamController::class, 'create'])->name('cams.create');
Route::get('/cams/{id}', [CamController::class, 'show'])->name('cams.show');
Route::post('/cams', [CamController::class, 'store'])->name('cams.store');
Route::get('/cams', [CamController::class, 'index'])->name('cams.index');
Route::get('/cams/{id}/send', [CamController::class, 'send'])->name('cams.send');

Route::get('/directories', [DirectoryController::class, 'index'])->name('directories.index');
Route::get('/directories/{id}/edit', [DirectoryController::class, 'edit'])->name('directories.edit');
Route::get('/directories/{id}', [DirectoryController::class, 'show'])->name('directories.show');
Route::get('/directories/{id}/send', [DirectoryController::class, 'send'])->name('directories.send');
