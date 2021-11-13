<?php

namespace App\Models;

use App\Services\PrecomputedValues\Values\ForShop\FeedOffersCount;
use App\Services\PrecomputedValues\Values\ForShop\FeedOffersGroupsCount;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FEED_DIR_NAME = 'feeds';

    public const IMPORT_WITHOUT_GROUPING = 'import_without_grouping';
    public const IMPORT_GROUP_BY_GROUP_ID = 'import_group_by_group_id';
    public const IMPORT_GROUP_BY_PICTURE = 'import_group_by_picture';
    public const IMPORT_GROUP_BY_URL = 'import_group_by_url';

    public const IMPORT_MAPPING_TARGET_FIELDS = [
        'forCategories' => 'Для категорий',
        'forEndCategory' => 'Для конечных категорий',
        'forTags' => 'Для тегов',
    ];

    protected $casts = [
        'import_mapping' => 'array',
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
            throw new \DomainException('Попытка активировать магазин без настроек импорта');
        }

        $this->is_active = !$this->is_active;
        $this->save();
    }

    public function isCanBeActive(): bool
    {
        return !is_null($this->import_grouping) && !is_null($this->import_mapping);
    }

    public function isImportWithoutGrouping()
    {
        return $this->import_grouping === static::IMPORT_WITHOUT_GROUPING;
    }

    public function isImportGroupByGroupId()
    {
        return $this->import_grouping === static::IMPORT_GROUP_BY_GROUP_ID;
    }

    public function isImportGroupByPicture()
    {
        return $this->import_grouping === static::IMPORT_GROUP_BY_PICTURE;
    }

    public function isImportGroupByUrl()
    {
        return $this->import_grouping === static::IMPORT_GROUP_BY_URL;
    }

    public function getAdmitadUrlAttribute()
    {
        return 'https://account.admitad.com/ru/webmaster/websites/867132/offers/' . $this->outer_id;
    }

    public function getImportGroupings(): array{
        return [
            null,
            static::IMPORT_WITHOUT_GROUPING,
            static::IMPORT_GROUP_BY_URL,
            static::IMPORT_GROUP_BY_PICTURE,
            static::IMPORT_GROUP_BY_GROUP_ID,
        ];
    }

    public function setImportGrouping(?string $import_grouping)
    {
        if (!in_array($import_grouping, $this->getImportGroupings())) {
            throw new \InvalidArgumentException('Неверный тип групировки');
        }

        $this->import_grouping = $import_grouping;
        if (is_null($import_grouping)) {
            $this->is_active = false;
        }
        $this->save();
    }

    public function setImportMapping(array $import_mapping)
    {
        $this->import_mapping = $import_mapping;
        if (empty($import_mapping)) {
            $this->is_active = false;
        }
        $this->save();
    }

    public function getFeedFileNameAttribute()
    {
        return storage_path(static::FEED_DIR_NAME) . '/' . $this->id . '.xml';
    }

    public function feed_offers_count()
    {
        return $this->hasOne(PrecomputedValue::class, 'object_id')->where('code', FeedOffersCount::CODE)->latest();
    }

    public function feed_offers_groups_count()
    {
        return $this->hasOne(PrecomputedValue::class, 'object_id')->where('code', FeedOffersGroupsCount::CODE)->latest();
    }

    public function getGroupCountAttribute()
    {
        $group_id_count = $this->feed_offers_groups_count->value['group_id_count'] ?? 0;
        $url_count = $this->feed_offers_groups_count->value['url_count'] ?? 0;
        $picture_count = $this->feed_offers_groups_count->value['picture_count'] ?? 0;

        $values = [];

        if ($group_id_count !== 0) {
            $values[] = $group_id_count;
        }

        if ($url_count !== 0) {
            $values[] = $url_count;
        }

        if ($picture_count !== 0) {
            $values[] = $picture_count;
        }

        if (empty($values)) {
            return 0;
        }

        return min(...$values);
    }

    public function feed_offers()
    {
        return $this->hasMany(FeedOffer::class);
    }
}
