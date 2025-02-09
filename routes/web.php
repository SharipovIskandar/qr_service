<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['middleware' => ['auth']], function () {

Route::get('/', function () {
    return view('qr.index');
})->name('qr.index');

Route::post('/generate-qr', [QrCodeController::class, 'generate'])->name('qr.generate');
Route::get('/download-qr/{id}', [QrCodeController::class, 'download'])->name('qr.download');
});


require __DIR__.'/auth.php';
