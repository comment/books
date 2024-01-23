<?php

namespace App\v1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id', 'title', 'parent_id', 'isActive', 'isDeleted'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class,'category_id');
    }
}
