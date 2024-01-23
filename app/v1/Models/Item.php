<?php

namespace App\v1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Item extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id', 'category_id', 'title', 'author', 'year', 'state', 'about_state', 'price', 'image', 'note', 'isActive', 'isDeleted'
    ];

    protected $casts = [
        'image' => 'array'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class,'image_id');
    }
}
