<?php

use App\v1\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'allItems']);
Route::get('/{id}', [ItemController::class, 'getItem']);
Route::post('/', [ItemController::class, 'createItem']);
Route::put('/{id}', [ItemController::class, 'updateItem']);
Route::delete('/{id}', [ItemController::class, 'deleteItem']);

