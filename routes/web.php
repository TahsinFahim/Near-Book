<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

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
    Route::prefix('menus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');          // Show DataTable
        Route::get('/data', [MenuController::class, 'data'])->name('data');         // AJAX DataTable source
        Route::post('/', [MenuController::class, 'store'])->name('store');     // Save new menu
        Route::put('/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/{menu}/delete', [MenuController::class, 'destroy'])->name('destroy'); // Delete menu
    });
    Route::prefix('submenus')->name('menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');          // Show DataTable
        Route::get('/data', [MenuController::class, 'data'])->name('data');         // AJAX DataTable source
        Route::post('/', [MenuController::class, 'store'])->name('store');     // Save new menu
        Route::put('/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/{menu}/delete', [MenuController::class, 'destroy'])->name('destroy'); // Delete menu
    });
});

require __DIR__ . '/auth.php';
