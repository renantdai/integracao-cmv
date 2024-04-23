<?php

use App\Http\Controllers\Admin\CamController;
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
