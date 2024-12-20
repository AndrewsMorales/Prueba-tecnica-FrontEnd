<?php

use App\Http\Controllers\CoctelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Coctel
    Route::get('/cocteles', [CoctelController::class, 'index'])->name('coctel.index');
    Route::post('/cocteles/getDataCoctelesCloud', [CoctelController::class, 'getDataCoctelesCloud'])->name('coctel.getDataCoctelesCloud');
    Route::post('/cocteles/getDataCoctelesLocal', [CoctelController::class, 'getDataCoctelesLocal'])->name('coctel.getDataCoctelesLocal');
    Route::post('/cocteles/saveUpdateDrink', [CoctelController::class, 'saveUpdateDrink'])->name('coctel.saveUpdateDrink');
    // Perfiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
