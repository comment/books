<?php

namespace App\v1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'id', 'title', 'author', 'year', 'description', 'isActive', 'isDeleted'
    ];
    protected $guarded = ['id'];
}
