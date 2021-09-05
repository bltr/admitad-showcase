<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'photos' => 'collection',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getNotSponsoredUrlAttribute()
    {
        $query = [];
        parse_str(parse_url($this->url)['query'], $query);

        return $query['ulp'];
    }
}
