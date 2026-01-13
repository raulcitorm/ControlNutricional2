<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/status', function () {
    return response()->json(['status' => 'ok','laravel' => app()->version()]);
});

Route::apiResources([
    'foods' => App\Http\Controllers\api\ApiFoodController::class,
]);
Route::post('/login', [App\Http\Controllers\ApiUserController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('foods', App\Http\Controllers\api\ApiFoodController::class);
   
});