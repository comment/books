<?php

use Illuminate\Support\Facades\Route;

Route::prefix('sanctum')->as('sanctum:')->group(
    base_path('routes/v1/auth.php'),
);

Route::prefix('categories')->as('categories:')->group(
    base_path('routes/v1/categories.php'),
);

Route::prefix('items')->as('items:')->group(
    base_path('routes/v1/items.php'),
);

Route::get('/unauthenticated', function () {
    return response()->json(
        [
            'errors' => [
                'status' => 401,
                'message' => 'Unauthenticated',
            ]
        ],
        401
    );
});
