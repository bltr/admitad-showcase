<?php

namespace App\Services\Catalog;

use App\Models\FeedOffer;
use App\Models\Offer;
use App\Models\Shop;

class ImportOffers
{
    public function handle(Shop $shop)
    {
        $hashs = Offer::where('shop_id', $shop->id)->pluck('hash', 'id');
        $query = FeedOffer::where('shop_id', $shop->id);

        if ($shop->import_type === Shop::IMPORT_GROUP_BY_GROUP_ID) {
            $query->groupByRaw("data ->> 'group_id'");
        } elseif($shop->import_type === Shop::IMPORT_GROUP_BY_URL) {
            $query->groupByRaw("data ->> 'url'");
        } elseif($shop->import_type === Shop::IMPORT_GROUP_BY_PICTURE) {
            $query->groupByRaw("data #>> '{pictures, 0}'");
        }

        if ($shop->import_type !== Shop::IMPORT_WITHOUT_GROUPING) {
            $query
                ->selectRaw("json_agg(id) as ids")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'price') as price")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'name') as name")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'url') as url")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'pictures') as photos")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY offer_id) as offer_id");
        } else {
            $query
                ->select('offer_id')
                ->selectRaw('json_build_array(id) as ids')
                ->selectRaw("data ->> 'price' as price")
                ->selectRaw("data ->> 'name' as name")
                ->selectRaw("data ->> 'url' as url")
                ->selectRaw("data ->> 'pictures' as photos");
        }
        $query->withCasts([
            'photos' => 'array',
            'ids' => 'array',
        ]);

        $query->cursor()->each(function (FeedOffer $feedOffer) use ($hashs, $shop) {
            $attr = $this->mapOffer($feedOffer, $shop);

            $hash = sha1(json_encode($attr));
            $attr['hash'] = $hash;
            if (!$hashs->has($feedOffer->offer_id)) {
                $id = Offer::create($attr)->id;
                FeedOffer::whereIn('id', $feedOffer->ids)->update(['offer_id' => $id]);
            } elseif ($hashs->get($feedOffer->catalog_offer_id) !== $hash) {
                $offer = Offer::find($feedOffer->offer_id);
                $offer->fill($attr)->save();
                FeedOffer::whereIn('id', $feedOffer->ids)->update(['offer_id' => $offer->id]);
            }

            $hashs->forget($feedOffer->offer_id);
        });

        Offer::whereIn('id', $hashs->keys())->delete();
    }

    protected function mapOffer(FeedOffer $offer, Shop $shop): array
    {
        return [
            'price' => (int)$offer->price,
            'name' => $offer->name,
            'url' => $offer->url,
            'photos' => $offer->photos,
            'shop_id' => $shop->id,
        ];
    }
}
