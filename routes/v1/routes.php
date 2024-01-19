<?php

use Illuminate\Support\Facades\Route;

Route::prefix('categories')->as('categories:')->group(
    base_path('routes/v1/categories.php'),
);

Route::prefix('items')->as('items:')->group(
    base_path('routes/v1/items.php'),
);

Route::prefix('books')->as('books:')->group(
    base_path('routes/v1/books.php'),
);
