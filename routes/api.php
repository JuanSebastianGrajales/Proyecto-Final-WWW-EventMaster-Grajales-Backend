<?php

use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\EventsController;
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
    Route::get('/events', 'index')->name('events');
    Route::post('/events', 'store');
    Route::patch('/events/{id}', 'updatePartial');
});

Route::get('/categories', [CategoriesController::class, 'index']);