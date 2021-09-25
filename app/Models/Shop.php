<?php

namespace App\Models;

use App\Models\Traits\SortedById;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    use SortedById;

    public const IMPORT_WITHOUT_GROUPING = 'import_without_grouping';
    public const IMPORT_GROUP_BY_GROUP_ID = 'import_group_by_group_id';
    public const IMPORT_GROUP_BY_PICTURE = 'import_group_by_picture';
    public const IMPORT_GROUP_BY_URL = 'import_group_by_url';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $guarded = [];

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function toggleActivity()
    {
        if (!$this->is_active && !$this->isCanBeActive()) {
            throw new \DomainException('Попытка активировать магазин без выбранного типа импорта');
        }

        $this->is_active = !$this->is_active;
        $this->save();
    }

    public function isCanBeActive(): bool
    {
        return $this->import_type !== null;
    }
}
