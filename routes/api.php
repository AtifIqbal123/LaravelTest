<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CompanyController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'companies', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::post('add', [CompanyController::class, 'store']);
    Route::get('edit/{id}', [CompanyController::class, 'edit']);
    Route::post('update/{id}', [CompanyController::class, 'update']);
    Route::delete('delete/{id}', [CompanyController::class, 'delete']);
});

////=======Employee========////
Route::group(['prefix' => 'employee', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('add', [EmployeeController::class, 'create']);
    Route::get('edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('update/{id}', [EmployeeController::class, 'update']);
    Route::delete('delete/{id}', [EmployeeController::class, 'delete']);
});