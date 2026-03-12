<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\ItineraireController;

/********** API Routes **********/
Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware("auth:sanctum")->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);

        // Users
        Route::get('/users', [UserController::class, 'show']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);

        // Destinations
        Route::get('/destinations', [DestinationController::class, 'index']);
        Route::get('/destinations/{id}', [DestinationController::class, 'show']);

        // Activities
        Route::get('/activities', [ActivityController::class, 'index']);
        Route::get('/activities/{id}', [ActivityController::class, 'show']);

        // Dishes
        Route::get('/dishes', [DishController::class, 'index']);
        Route::get('/dishes/{id}', [DishController::class, 'show']);

        // Itineraires
        Route::get('/itineraires', [ItineraireController::class, 'index']);
        Route::post('/itineraires', [ItineraireController::class, 'store']);
        Route::get('/itineraires/{id}', [ItineraireController::class, 'show']);
        Route::put('/itineraires/{id}', [ItineraireController::class, 'update']);
        Route::delete('/itineraires/{id}', [ItineraireController::class, 'destroy']);

    });

});