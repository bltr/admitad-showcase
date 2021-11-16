<?php


namespace App\Services\Feed;


use App\Models\FeedCategory;
use App\Models\Shop;
use App\Services\Feed\SyncFeedAction\CategoryTagSynchronizer;
use App\Services\Feed\SyncFeedAction\OfferTagSynchronizer;
use Illuminate\Support\Facades\DB;

class SyncFeedAction
{
    private CategoryTagSynchronizer $categoryTagSynchronizer;
    private OfferTagSynchronizer $offerTagSynchronizer;

    public function __construct(
        CategoryTagSynchronizer $categoryTagSynchronizer,
        OfferTagSynchronizer $offerTagSynchronizer
    )
    {
        $this->categoryTagSynchronizer = $categoryTagSynchronizer;
        $this->offerTagSynchronizer = $offerTagSynchronizer;
    }

    public function __invoke(Shop $shop)
    {
        $synchronized_at = now();
        $this->categoryTagSynchronizer->sync($shop, $synchronized_at);
        $this->offerTagSynchronizer->sync($shop, $synchronized_at);
        $this->fixCategoriesTree($shop);
        $this->seedFeedCategoryIdOfOffers($shop);
    }

    private function fixCategoriesTree(Shop $shop): void
    {
        $this->seedParentIdOfCategories($shop);
        FeedCategory::scoped(['shop_id' => $shop->id])->fixTree();
    }

    private function seedParentIdOfCategories(Shop $shop): void
    {
        DB::update(<<<QUERY
                update feed_categories set parent_id = f_c.id
                from feed_categories as f_c
                where f_c.outer_id = (feed_categories.data ->> 'parentId')
                  and (feed_categories.data ->> 'parentId') <> 'null'
                  and f_c.shop_id = {$shop->id}
                  and feed_categories.shop_id = {$shop->id};
            QUERY
        );
    }

    private function seedFeedCategoryIdOfOffers(Shop $shop): void
    {
        DB::update(
            <<<QUERY
                update feed_offers set feed_category_id = feed_categories.id
                from feed_categories
                where feed_categories.outer_id=feed_offers.data ->> 'categoryId'
                 and feed_categories.shop_id = {$shop->id}
                 and feed_offers.shop_id = {$shop->id};
            QUERY
        );
    }
}
