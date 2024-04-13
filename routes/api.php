<?php

use App\Http\Controllers\Api\v1\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/v1/position/move', [PositionController::class, 'move']);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
