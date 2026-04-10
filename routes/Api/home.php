<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\API\BookSearchController;

 Route::get('/banner', [HomeController::class, 'banner']);
 Route::get('/books/category/{categoryId}', [HomeController::class, 'booksByCategory']);
 Route::get('/book/details/{id}', [HomeController::class, 'bookDetails']);


Route::get('/book-search', [BookSearchController::class, 'search']);
