<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    protected $fillable = [
        'food_blog_id',
        'session_id',
        'view_date',
        'ip_address',
        'user_agent',
    ];

    public function foodBlog()
    {
        return $this->belongsTo(FoodBlog::class);
    }
}
