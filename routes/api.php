<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth.api');



Route::middleware('auth.api')->group(function () {

    Route::get('/bookings/all-bookings', [BookingController::class, 'allBookings']);
    Route::get('/bookings/filter-bookings', [BookingController::class, 'filterBookings']);
    Route::post('/bookings/{id}', [BookingController::class, 'update']);
    Route::post('/payments/{id}', [PaymentController::class, 'update']);
    Route::post('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::post('/users/{id}', [UserController::class, 'update']);
    Route::resource('/bookings', BookingController::class);
    Route::resource('/vehicles', VehicleController::class);
    Route::resource('/payments', PaymentController::class);
    Route::resource('/users', UserController::class);

    Route::get('/available/vehicles', [VehicleController::class, 'availableVehicles']);
    Route::post('/vehicles/assigned', [VehicleController::class, 'assignedVehicle']);

});




