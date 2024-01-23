<?php

namespace App\v1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'id', 'item_id', 'filename', 'isActive', 'isDeleted'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class,'id');
    }
}
