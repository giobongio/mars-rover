<?php

use App\Http\Controllers\v1\MarsRoverController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/marsrover/setPosition', [MarsRoverController::class, 'setPosition']);
Route::post('/v1/marsrover/sendCommands', [MarsRoverController::class, 'sendCommands']);
Route::post('/v1/marsrover/wrap', [MarsRoverController::class, 'wrap']);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
