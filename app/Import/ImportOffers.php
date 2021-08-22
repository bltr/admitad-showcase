<?php

namespace App\Import;

use App\Models\FeedOffer;
use App\Models\Offer;
use App\Models\Shop;

class ImportOffers
{
    public function handle(Shop $shop)
    {
        $hashs = Offer::where('shop_id', $shop->id)->pluck('hash', 'id');
        $query = FeedOffer::query();

        if ($shop->import_type === Shop::IMPORT_GROUP_BY_GROUP_ID) {
            $query->groupByRaw("data ->> 'group_id'");
        } elseif($shop->import_type === Shop::IMPORT_GROUP_BY_URL) {
            $query->groupByRaw("data ->> 'url'");
        } elseif($shop->import_type === Shop::IMPORT_GROUP_BY_PICTURE) {
            $query->groupByRaw("data #>> '{pictures, 0}'");
        }

        if ($shop->import_type !== null) {
            $query
                ->selectRaw("json_agg(id) as ids")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'price') as price")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'name') as name")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'url') as url")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY data ->> 'pictures') as photo")
                ->selectRaw("mode() WITHIN GROUP (ORDER BY catalog_offers_id) as catalog_offers_id");
        } else {
            $query
                ->select('catalog_offers_id')
                ->selectRaw("data ->> 'price' as price")
                ->selectRaw("data ->> 'name' as name")
                ->selectRaw("data ->> 'url' as url")
                ->selectRaw("data ->> 'pictures' as photo");
        }

        $query->cursor()->each(function (FeedOffer $offer) use ($hashs, $shop) {
            $attr = $this->mapOffer($offer, $shop);

            $hash = sha1(json_encode($attr));
            $attr['hash'] = $hash;
            if (!$hashs->has($offer->catalog_offers_id)) {
                $id = Offer::create($attr)->id;
                FeedOffer::whereIn('id', json_decode($offer->ids))->update(['catalog_offers_id' => $id]);
            } elseif ($hashs->get($offer->catalog_offer_id) !== $hash) {
                $catalog_offer = Offer::find($offer->catalog_offers_id);
                $catalog_offer->fill($attr)->save();
                FeedOffer::whereIn('id', json_decode($offer->ids))->update(['catalog_offers_id' => $catalog_offer->id]);
                $hashs->forget($offer->catalog_offers_id);
            }

            Offer::whereIn('id', $hashs->keys())->delete();
        });
    }

    protected function mapOffer(FeedOffer $offer, Shop $shop): array
    {
        return [
            'price' => (int)$offer->price,
            'name' => $offer->name,
            'url' => $offer->url,
            'photo' => $offer->photo,
            'shop_id' => $shop->id,
        ];
    }
}
