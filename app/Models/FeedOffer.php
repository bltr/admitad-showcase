<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class FeedOffer extends Model
{
    use HasFactory, HasJsonRelationships;

    protected $guarded = [];

    protected $casts = [
        'data' => 'object'
    ];

    public function getPicturesAttribute()
    {
        return collect($this->data->pictures);
    }

    public function getNotSponsoredUrlAttribute()
    {
        $query = [];
        parse_str(parse_url($this->data->url)['query'], $query);

        return $query['ulp'];
    }

    public function getRawDataAttribute()
    {
        return $this->attributes['data'];
    }

    public function category()
    {
        return $this->belongsTo(FeedCategory::class, 'data->categoryId', 'outer_id')->with('ancestors');
    }

    public function getFullCategoryNameAttribute()
    {
        return $this->category->ancestors->pluck('name')->implode(' • ') . ' • ' . $this->category->name;
    }
}
