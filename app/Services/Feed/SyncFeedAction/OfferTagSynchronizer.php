<?php

namespace App\Services\Feed\SyncFeedAction;

use App\Models\FeedOffer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class OfferTagSynchronizer extends TagSynchronizer
{
    protected function query(): Builder
    {
        return FeedOffer::query();
    }

    protected function processEntry(array $entry): array
    {
        $entry[Str::plural('picture')] = (array)($entry['picture'] ?? []);
        unset($entry['picture']);

        return $entry;
    }

    protected function tagName(): string
    {
        return 'offer';
    }
}
