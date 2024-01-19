<?php

use App\v1\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'allBooks']);
Route::get('/{id}', [BookController::class, 'getBook']);
Route::post('/', [BookController::class, 'createBook']);
Route::put('/{id}', [BookController::class, 'updateBook']);
Route::delete('/{id}', [BookController::class, 'deleteBook']);

