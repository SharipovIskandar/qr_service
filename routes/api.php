<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\QrCodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
Route::post('/generate-qrcode', [QrCodeController::class, 'generate']);
Route::post('/read-qrcode', [QrCodeController::class, 'read']);
});
