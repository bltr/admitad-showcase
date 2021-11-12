<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedOffer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'inserted_at' => 'datetime',
        'updated_at' => 'datetime',
        'synchronized_at' => 'datetime',
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

    public function feed_category()
    {
        return $this->belongsTo(FeedCategory::class);
    }

    public function getFullCategoryNameAttribute()
    {
        if ($this->feed_category) {
            return $this->feed_category->ancestors->pluck('name')->implode(' • ') . ' • ' . $this->feed_category->name;
        }

        return '-';
    }

    public function scopeInvalid(Builder $query): Builder
    {
        return $query->whereNull('data->price')
            ->orWhereRaw("data -> 'pictures' = '[]'::jsonb")
            ->orWhereNull('data->url');
    }
}
