<?php

use Illuminate\Support\Facades\Route;

Route::prefix('books')->as('books:')->group(
    base_path('routes/v1/books.php'),
);
