<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IntegrationController;
use App\Http\Controllers\Api\RepositoryFtpController;
use App\Http\Controllers\Api\CamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::namespace('API')->name('api.')->group(function () {
    Route::post('/capture', [IntegrationController::class, 'capture']);
    Route::post('/ftp/test', [RepositoryFtpController::class, 'testarConexao']);
    Route::post('/ftp/php/test', [RepositoryFtpController::class, 'testarConexaoPHP']);
    Route::get('/ftp', [RepositoryFtpController::class, 'show']);
    Route::get('/ftp/verificar', [RepositoryFtpController::class, 'verificaRepositorio']);
    Route::get('/ftp/verificar/{directory}', [RepositoryFtpController::class, 'verificaRepositorioFtp']);
    Route::get('/sftp/verificar/{directory}', [RepositoryFtpController::class, 'verificaRepositorioSftp']);

    Route::get('/directory/send', [RepositoryFtpController::class, 'directorySend']);

    Route::post('/cam', [CamController::class, 'store']);
    Route::post('/cam/send', [CamController::class, 'send']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
