<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;

 Route::get('/banner', [HomeController::class, 'banner']);
