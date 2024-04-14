<?php

use App\Http\Controllers\v1\MarsRoverController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/rover/sendCommands', [MarsRoverController::class, 'sendCommands']);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
