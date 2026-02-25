<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodBlog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status'
    ];
}
