<?php

namespace App\Services\Feed\SyncFeedAction;

use App\Models\FeedCategory;
use Illuminate\Database\Eloquent\Builder;

class CategoryTagSynchronizer extends TagSynchronizer
{
    protected function query(): Builder
    {
        return FeedCategory::query();
    }

    protected function processEntry(array $entry): array
    {
        return $entry;
    }

    protected function tagName(): string
    {
        return 'category';
    }
}
