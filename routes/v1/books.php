<?php

use App\v1\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index']);
Route::get('/{id}', [BookController::class, 'show']);
Route::post('/', [BookController::class, 'store']);
Route::put('/{id}', [BookController::class, 'update']);
Route::delete('/{id}', [BookController::class, 'destroy']);

