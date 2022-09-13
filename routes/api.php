<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StaffUserController;
use App\Models\GeneralSettings;
use App\Models\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("auth")->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('signup-business', [AuthController::class, 'signupBusiness']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix("user")->middleware("auth:sanctum")->group(function () {
    Route::post('verify', [AuthController::class, 'verify']);
});

Route::prefix("business-account")->middleware("auth:sanctum")->group(function () {
    Route::post('enrollStaffUser', [StaffUserController::class, 'enrollStaffUser']);
    Route::get('getAllStaffUsers', [StaffUserController::class, 'getAllStaffUsers']);
    Route::post('enrollEvent', [EventsController::class, 'enrollEvent']);
    Route::get('getAllEvents', [EventsController::class, 'getAllEvents']);
    Route::post('enrollGeneralSettings', [GeneralSettingsController::class, 'enrollGeneralSettings']);
    Route::get('getGeneralSettings', [GeneralSettingsController::class, 'getGeneralSettings']);
    Route::post('enrollServices', [ServicesController::class, 'enrollServices']);
    Route::get('getAllServices', [ServicesController::class, 'getAllServices']);
    Route::get('enrollServicesPayment', [ServicesController::class, 'enrollServicesPayment']);
    Route::post('enrollPet', [PetsController::class, 'enrollPet']);
    Route::get('getBusinessAccountPets', [PetsController::class, 'getBusinessAccountPets']);
    Route::get('getBusinessAccountPetsList', [PetsController::class, 'getBusinessAccountPetsList']);
    Route::post('enrollClient', [ClientController::class, 'enrollClient']);
    Route::get('getServiceIcons', [ServicesController::class, 'getServiceIcons']);
    Route::post('enrollBusinessBooking', [BookingController::class, 'enrollBusinessBooking']);
});
