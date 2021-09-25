<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait SortedById
{
    protected static function bootSortedById()
    {
        static::addGlobalScope('sorted_by_id', function (Builder $builder) {
            $builder->orderBy('id');
        });
    }
}
