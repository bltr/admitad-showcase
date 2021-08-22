<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    public $table = 'feed_analytics';

    protected $guarded = [];

    protected $casts = [
        'data' => 'json'
    ];
}
