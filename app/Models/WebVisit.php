<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebVisit extends Model
{
    protected $fillable = [
        'session_id',
        'page_key',
        'view_date',
        'ip_address',
        'user_agent',
    ];
}
