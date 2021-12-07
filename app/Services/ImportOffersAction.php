<?php

namespace App\Services;

use App\Models\FeedOffer;
use App\Models\Offer;
use App\Models\Shop;
use App\Utils\LazyCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ImportOffersAction
{
    private const CHUNK_SIZE = 500;

    private Shop $shop;
    private Carbon  $imported_at;

    public function __invoke(Shop $shop)
    {
        $this->shop = $shop;
        $this->imported_at = now();

        $this->query()
            ->cursor()
            ->chunk(static::CHUNK_SIZE)
            ->each(function (LazyCollection $feedOffers) {
                $this->importChunk($feedOffers);
            });

        Offer::where('shop_id', $shop->id)
            ->where('imported_at', '<>', $this->imported_at)
            ->delete();
    }

    private function query(): Builder
    {
        $query = FeedOffer::with('feed_category')
            ->valid()
            ->where('shop_id', $this->shop->id);

        if ($this->shop->isImportGroupByGroupId()) {
            $query->groupByRaw("data ->> 'group_id'");
        } elseif ($this->shop->isImportGroupByUrl()) {
            $query->groupByRaw("data ->> 'url'");
        } elseif ($this->shop->isImportGroupByPicture()) {
            $query->groupByRaw("data #>> '{pictures, 0}'");
        }

        if (!$this->shop->isImportWithoutGrouping()) {
            $query
                ->selectRaw("json_agg(id) as ids")
                ->selectRaw("(array_agg(group_id))[1] as group_id") // брать первый не пустой
                ->selectRaw("(array_agg(feed_category_id))[1] as feed_category_id")
                ->selectRaw("(array_agg(data))[1] as data");
        } else {
            $query
                ->selectRaw('json_build_array(id) as ids')
                ->addSelect(
                    'group_id',
                    'feed_category_id',
                    'data'
                );
        }

        $query->withCasts([
            'photos' => 'array',
            'ids' => 'array',
        ]);

        return $query;
    }

    private function importChunk(LazyCollection $feedOffers)
    {
        $valuesToUpsert = [];
        $hashs = Offer::where('shop_id', $this->shop->id)
            ->whereIn('id', $feedOffers->pluck('offer_id'))
            ->pluck('hash', 'id');

        foreach($feedOffers as $feedOffer) {
            $attr = $this->mapOffer($feedOffer);

            if (!$hashs->has($feedOffer->offer_id) || $hashs->get($feedOffer->catalog_offer_id) !== $attr['hash']) {
                $valuesToUpsert[] = $attr;
                $hashs->forget($feedOffer->offer_id);
            }
        }

        FeedOffer::upsert($valuesToUpsert, ['shop_id', 'id'], ['updated_at', 'imported_at', 'price', 'url', 'photos', 'feed_data']);

        if ($hashs->isNotEmpty()) {
            Offer::where('shop_id', $this->shop->id)
                ->whereIn('id', $hashs->keys())
                ->update(['imported_at' =>  $this->imported_at]);
        }
    }

    protected function mapOffer(FeedOffer $offer): array
    {
        $attr = [
            'price' => (int)$offer->data->price,
            'url' => $offer->data->url,
            'photos' => $offer->data->pictures,
            'feed_data' => $this->mapFeedData($offer),
        ];

        $hash = sha1(json_encode($attr));
        $attr['hash'] = $hash;
        $attr['id'] =$offer->offer_id;
        $attr['created_at'] =$this->imported_at;
        $attr['updated_at'] =$this->imported_at;
        $attr['imported_at'] =$this->imported_at;
        $attr['shop_id'] =$this->shop->id;

        return $attr;
    }

    private function mapFeedData($feed_offer)
    {
        $result = [];

        foreach ($this->shop->import_included_fields as $field) {
            if ($field === 'full_category_name') {
                $result[$field] = $feed_offer->full_category_name;
            } else {
                $result[$field] = $feed_offer->data->{$field} ?? null;
            }
        }

        return $result;
    }
}
