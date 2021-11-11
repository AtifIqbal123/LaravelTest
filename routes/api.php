<?php

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'companies', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::post('add', [CompanyController::class, 'store']);
    Route::get('edit/{id}', [CompanyController::class, 'edit']);
    Route::post('update/{id}', [CompanyController::class, 'update']);
    Route::delete('delete/{id}', [CompanyController::class, 'destroy']);
});
