<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedOffer extends Model
{
    use HasFactory;

    protected $table = 'feed_offers';

    protected $guarded = [];

    protected $casts = [
        'data' => 'object'
    ];

    protected static array $categories;

    public function getPicturesAttribute()
    {
        return collect($this->data->pictures);
    }

    public function getUrlAttributeXXX()
    {
        $query = [];
        parse_str(parse_url($this->data->url)['query'], $query);

        return $query['ulp'];
    }

    public function getRawDataAttribute()
    {
        return $this->attributes['data'];
    }

    public function fullCategoryName()
    {
        if (empty(self::$categories)) {
            self::$categories = FeedCategory::all()->keyBy('outer_id')->all();
        }

        $result = '';
        // $offer->categoryId['value'] - for kupivip
        $category_id = $this->data->categoryId->value ?? $this->data->categoryId;

        while ($category_id !== null) {
            $category = self::$categories[$category_id];
            $result .= ' • ' . $category->name;
            $category_id = $category->parentId ?? null;
        }

        return $result;
    }
}
