<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class FeedCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $primaryKey = 'outer_id';

    protected $guarded = [];

    protected $casts = [
        'data' => 'object'
    ];

    protected function getScopeAttributes()
    {
        return ['shop_id'];
    }

    public function getNameAttribute()
    {
        return $this->data->value;
    }
}
