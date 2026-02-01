<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubmenuContorller;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\SiteLogoController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\TopNavbarController;

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

    Route::prefix('publishers')->name('publishers.')->group(function () {
        Route::get('/', [PublisherController::class, 'index'])->name('index');
        Route::get('/data', [PublisherController::class, 'data'])->name('data');
        Route::post('/', [PublisherController::class, 'store'])->name('store');
        Route::put('/{publisher}', [PublisherController::class, 'update'])->name('update');
        Route::delete('/{publisher}', [PublisherController::class, 'destroy'])->name('destroy');
});

  Route::prefix('site-logo')->name('site-logo.')->group(function () {
        Route::get('/', [SiteLogoController::class, 'index'])->name('index');
        Route::get('/data', [SiteLogoController::class, 'data'])->name('data');
        Route::post('/', [SiteLogoController::class, 'store'])->name('store');
        Route::put('/{siteLogo}', [SiteLogoController::class, 'update'])->name('update');
        Route::delete('/{siteLogo}', [SiteLogoController::class, 'destroy'])->name('destroy');

});

  Route::prefix('contact-info')->name('contact-info.')->group(function () {
       Route::get('/', [ContactInfoController::class, 'index'])->name('index');
        Route::get('/data', [ContactInfoController::class, 'data'])->name('data');
        Route::post('/', [ContactInfoController::class, 'store'])->name('store');
        Route::put('/{contactInfo}', [ContactInfoController::class, 'update'])->name('update');
        Route::delete('/{contactInfo}', [ContactInfoController::class, 'destroy'])->name('destroy');
});

  Route::prefix('banners')->name('banners.')->group(function () {
       Route::get('/', [BannerController::class, 'index'])->name('index');
        Route::get('/data', [BannerController::class, 'data'])->name('data');
        Route::post('/', [BannerController::class, 'store'])->name('store');
        Route::put('/{banner}', [BannerController::class, 'update'])->name('update');
        Route::delete('/{banner}', [BannerController::class, 'destroy'])->name('destroy');

});

  Route::prefix('top-navbar')->name('top-navbar.')->group(function () {
       Route::get('/', [TopNavbarController::class, 'index'])->name('index');
        Route::get('/data', [TopNavbarController::class, 'data'])->name('data');
        Route::post('/', [TopNavbarController::class, 'store'])->name('store');
        Route::put('/{topNavbar}', [TopNavbarController::class, 'update'])->name('update');
        Route::delete('/{topNavbar}', [TopNavbarController::class, 'destroy'])->name('destroy');
});

});

require __DIR__ . '/auth.php';
