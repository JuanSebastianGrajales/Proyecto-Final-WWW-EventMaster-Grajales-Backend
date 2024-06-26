<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\RegistrationsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');


Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::controller(EventsController::class)->group(function() {
    Route::get('/events', 'index');
    Route::post('/events', 'store');
    Route::patch('/events/{id}', 'updatePartial');
    Route::get('/events-created/{id}', 'createdBy');
});

Route::get('/categories', [CategoriesController::class, 'index']);

Route::controller(RegistrationsController::class)->group(function() {
    Route::get('/registrations', 'index');
    Route::post('/registrations', 'store');
    Route::delete('/registrations/{user_id}/{event_id}', 'destroy');
    Route::get('/registrations-history/{user_id}', 'registrationsUser');
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

    Route::controller(UserController::class)->group(function() {
        Route::get('/users', 'index');
        Route::post('/users', 'store');
        Route::get('/users/{id}', 'show');
        Route::put('/users/{id}', 'updateProfile'); // Changed to 'put'
    });
