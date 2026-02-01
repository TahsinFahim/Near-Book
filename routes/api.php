<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TopNavbarController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

 Route::get('/top-menu', [TopNavbarController::class, 'index']);
  Route::get('/categoris', [TopNavbarController::class, 'categoris']);





require __DIR__ . '/Api/home.php';
