<?php

namespace App\Models;

class ImportMapping
{
    public const UNUSED_FIELDS = [
        'price',
        'vendor',
        'currencyId',
        'group_id',
        'oldprice',
        'url',
        'param',
        'pictures',
        'available',
        'id',
        'modified_time',
    ];

    public static function isUnusedField(string $field): bool
    {
        return in_array($field, static::UNUSED_FIELDS);
    }

    private array $forCategories = [];

    private array $forEndCategory = [];

    private array $forTags = [];
}
