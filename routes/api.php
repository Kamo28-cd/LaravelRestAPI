<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\FilmController;
use App\Http\Controllers\Api\V1\MoviesController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\DirectorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('customers', CustomerController::class); //apiResource same  as resource controllers thing but omits create and edit
    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('directors', DirectorController::class);
    Route::apiResource('movies', MoviesController::class);
    Route::apiResource('films', FilmController::class);

    Route::post('invoices/bulk', ['uses' => 'InvoiceController@bulkStore']);
});
