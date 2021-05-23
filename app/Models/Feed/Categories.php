<?php

namespace App\Models\Feed;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
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
