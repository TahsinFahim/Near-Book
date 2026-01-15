<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubmenuContorller;

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
    Route::prefix('submenus')->name('submenus.')->group(function () {
        Route::get('/{id}', [SubmenuContorller::class, 'index'])->name('index');          // Show DataTable
        Route::get('/data/{id}', [SubmenuContorller::class, 'data'])->name('data');         // AJAX DataTable source
        Route::post('/', [SubmenuContorller::class, 'store'])->name('store');     // Save new menu
        Route::put('/{submenu}', [SubmenuContorller::class, 'update'])->name('update');
        Route::delete('/{menu}/delete', [SubmenuContorller::class, 'destroy'])->name('destroy'); // Delete menu
    });


    // Categories page
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/data', [CategoryController::class, 'data'])->name('data');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('sub-categories')->group(function () {
        Route::get('/{id}', [SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('/data/{id}', [SubCategoryController::class, 'data'])->name('sub-categories.data');
        Route::post('/', [SubCategoryController::class, 'store'])->name('sub-categories.store');
        Route::put('/{id}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
        Route::delete('/{id}', [SubCategoryController::class, 'destroy'])->name('sub-categories.destroy');
    });

    Route::prefix('authors')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('authors.index');
        Route::get('/data', [AuthorController::class, 'data'])->name('authors.data');
        Route::post('/', [AuthorController::class, 'store'])->name('authors.store');
        Route::put('/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    });

    Route::prefix('books')->group(function () {
        Route::get('/', [BookController::class, 'index'])->name('books.index');
        Route::get('/data', [BookController::class, 'data'])->name('books.data');
        Route::post('/', [BookController::class, 'store'])->name('books.store');
        Route::put('/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    });
    Route::get('/categories/{category}/sub-categories', [CategoryController::class, 'subCategories']);

});

require __DIR__ . '/auth.php';
