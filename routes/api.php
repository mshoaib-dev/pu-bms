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

    Route::resource('/users', UserController::class);
    Route::resource('/bookings', BookingController::class);
    Route::post('/bookings/{id}', [BookingController::class, 'update']);
    Route::resource('/vehicles', VehicleController::class);
    Route::resource('/payments', PaymentController::class);

    Route::get('/available/vehicles', [VehicleController::class, 'availableVehicles']);
    Route::post('/vehicles/assigned', [VehicleController::class, 'assignedVehicle']);

});




