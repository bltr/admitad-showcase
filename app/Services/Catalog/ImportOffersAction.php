<?php

namespace App\Services\Catalog;

use App\Models\FeedOffer;
use App\Models\Offer;
use App\Models\Shop;

class ImportOffersAction
{
    public function __invoke(Shop $shop)
    {
        $hashs = Offer::where('shop_id', $shop->id)->pluck('hash', 'id');
        $query = FeedOffer::with('feed_category')->where('shop_id', $shop->id);

        if ($shop->isImportGroupByGroupId()) {
            $query->groupByRaw("data ->> 'group_id'");
        } elseif($shop->isImportGroupByUrl()) {
            $query->groupByRaw("data ->> 'url'");
        } elseif($shop->isImportGroupByPicture()) {
            $query->groupByRaw("data #>> '{pictures, 0}'");
        }

        if (!$shop->isImportWithoutGrouping()) {
            $query
                ->selectRaw("json_agg(id) as ids")
                ->selectRaw("(array_agg(offer_id))[1] as offer_id")
                ->selectRaw("(array_agg(feed_category_id))[1] as feed_category_id")
                ->selectRaw("(array_agg(data))[1] as data");
        } else {
            $query
                ->selectRaw('json_build_array(id) as ids')
                ->addSelect(
                    'offer_id',
                    'feed_category_id',
                    'data'
                )
            ;
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
            'price' => (int)$offer->data->price,
            'url' => $offer->data->url,
            'photos' => $offer->data->pictures,
            'shop_id' => $shop->id,
            'vendor' => $offer->data->vendor,
            'params' => $offer->data->param ?? null,
            'for_categories' => $this->mapField($offer, $shop, 'for_categories'),
            'for_end_category' => $this->mapField($offer, $shop, 'for_end_category'),
            'for_tags' => $this->mapField($offer, $shop, 'for_tags'),
        ];
    }

    protected function mapField(FeedOffer $offer, Shop $shop, $field): ?string
    {
        if (empty($shop->import_mapping[$field])) {
            return null;
        }

        $result = '';
        foreach ($shop->import_mapping[$field] as $attribute) {
            if (in_array($attribute, ['full_category_name', 'category_name'])) {
                $result .= $offer->{$attribute};
            } else {
                $result .= $offer->data->{$attribute} ?? '';
            }
        }

        return $result;
    }
}
