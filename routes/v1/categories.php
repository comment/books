<?php

use App\v1\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'allCategories']);
Route::get('/{id}', [CategoryController::class, 'getCategory']);
Route::post('/', [CategoryController::class, 'createCategory']);
Route::put('/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('/{id}', [CategoryController::class, 'deleteCategory']);

