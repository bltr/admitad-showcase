<?php

namespace App\Services\PrecomputedValues;

use App\Models\PrecomputedValue;
use App\Models\Shop;
use App\Services\PrecomputedValues\Values\ActiveShopsCount;
use App\Services\PrecomputedValues\Values\ForShop\FeedOffersCount;
use App\Services\PrecomputedValues\Values\ForShop\FeedOffersDistinctFields;
use App\Services\PrecomputedValues\Values\ForShop\FeedOffersGroupDeviations;
use App\Services\PrecomputedValues\Values\ForShop\FeedOffersGroupsCount;
use App\Services\PrecomputedValues\Values\ForShop\InvalidFeedOffersCount;
use App\Services\PrecomputedValues\Values\TotalFeedOffersCount;
use App\Services\PrecomputedValues\Values\TotalOffersCount;
use App\Services\PrecomputedValues\Values\TotalShopsCount;

class PrecomputedValuesService
{
    const LAST_REPORTS_COUNT = 2;

    private array $totalValuesClasses = [
        TotalShopsCount::class,
        ActiveShopsCount::class,
        TotalFeedOffersCount::class,
        TotalOffersCount::class,
    ];

    private array $valuesClassesForShops = [
        FeedOffersCount::class,
        InvalidFeedOffersCount::class,
        FeedOffersGroupsCount::class,
        FeedOffersGroupDeviations::class,
        FeedOffersDistinctFields::class,
    ];

    public function calc(): void
    {
        $this->calcTotalValues();

        Shop::all()->each(fn($shop) => $this->calcValuesForShop($shop->id));
    }

    private function calcTotalValues(): void
    {
        foreach ($this->totalValuesClasses as $class) {
            PrecomputedValue::create([
                'value' => app($class)->calc(),
                'code' => $class::CODE
            ]);
        }
    }

    private function calcValuesForShop(int $shop_id): void
    {
        foreach ($this->valuesClassesForShops as $class) {
            PrecomputedValue::create([
                'object_id' => $shop_id,
                'value' => app($class, ['shop_id' => $shop_id])->calc(),
                'code' => $class::CODE
            ]);
        }
    }

    public function getLastTotalValues(): array
    {
        return PrecomputedValue::whereIn('code', array_map(fn($class) => $class::CODE, $this->totalValuesClasses))
            ->latest()
            ->limit(count($this->totalValuesClasses))
            ->pluck('value', 'code')
            ->all();
    }

    public function getLastValuesForShop(int $shop_id): array
    {
        return PrecomputedValue::whereIn('code', array_map(fn($class) => $class::CODE, $this->valuesClassesForShops))
            ->where('object_id', $shop_id)
            ->latest()
            ->limit(count($this->valuesClassesForShops))
            ->pluck('value', 'code')
            ->all();
    }

    public function getLastValueForShop(int $shop_id, string $code)
    {
        return PrecomputedValue::whereIn('code', array_map(fn($class) => $class::CODE, $this->valuesClassesForShops))
            ->where('object_id', $shop_id)
            ->where('code', $code)
            ->latest()
            ->value('value');
    }
}
