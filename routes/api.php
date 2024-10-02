<?php

use App\Http\Controllers\UsersController;
use App\Http\Controllers\AppointmentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//this is the endpoint to login and register with prefix api
Route::post('/login', [UsersController::class, 'login']);
Route::post('/register', [UsersController::class, 'register']);

//this group mean return user's data if authenticated successfully
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UsersController::class, 'index']);
    Route::post('/book', [AppointmentsController::class, 'store']);
    Route::get('/appointments', [AppointmentsController::class, 'index']); // retrieve all appointments of the authenticated user
});
