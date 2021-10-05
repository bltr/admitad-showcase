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

    public const FEED_DIR_NAME = 'feeds';

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

    public function isImportWithoutGrouping()
    {
        return $this->import_type === static::IMPORT_WITHOUT_GROUPING;
    }

    public function isImportGroupByGroupId()
    {
        return $this->import_type === static::IMPORT_GROUP_BY_GROUP_ID;
    }

    public function isImportGroupByPicture()
    {
        return $this->import_type === static::IMPORT_GROUP_BY_PICTURE;
    }

    public function isImportGroupByUrl()
    {
        return $this->import_type === static::IMPORT_GROUP_BY_URL;
    }

    public function getAdmitadUrlAttribute()
    {
        return 'https://account.admitad.com/ru/webmaster/websites/867132/offers/' . $this->outer_id;
    }

    public function report()
    {
        return $this->hasOne(Report::class, 'object_id')->latest();
    }

    public function getImportTypes(): array{
        return [
            null,
            static::IMPORT_WITHOUT_GROUPING,
            static::IMPORT_GROUP_BY_URL,
            static::IMPORT_GROUP_BY_PICTURE,
            static::IMPORT_GROUP_BY_GROUP_ID,
        ];
    }

    public function setImportType(?string $import_type)
    {
        if (!in_array($import_type, $this->getImportTypes())) {
            throw new \InvalidArgumentException('Неверный тип импорта');
        }

        $this->import_type = $import_type;
        if (is_null($import_type)) {
            $this->is_active = false;
        }
        $this->save();
    }

    public function getFeedFileNameAttribute()
    {
        return storage_path(static::FEED_DIR_NAME) . '/' . $this->id . '.xml';
    }
}
