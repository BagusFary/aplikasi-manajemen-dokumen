<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;


Route::get('/users', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->group( function() {
});