<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class FeedCategory extends Model
{
    use HasFactory, NodeTrait;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'inserted_at' => 'datetime',
        'updated_at' => 'datetime',
        'synchronized_at' => 'datetime',
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
