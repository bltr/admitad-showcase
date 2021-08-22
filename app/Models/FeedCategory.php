<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedCategory extends Model
{
    use HasFactory;

    protected $table = 'feed_categories';

    protected $guarded = [];

    protected $casts = [
        'data' => 'object'
    ];

    public function getParentIdAttribute()
    {
        return $this->data->parentId ?? null;
    }

    public function getNameAttribute()
    {
        return $this->data->value;
    }
}
