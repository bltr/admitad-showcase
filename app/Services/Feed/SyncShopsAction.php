<?php

namespace App\Services\Feed;

use App\Models\Shop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncShopsAction
{
    const TOKEN_KEY = 'admitad_access_token';

    /**
     * @see https://account.admitad.com/ru/webmaster/websites/867132/
     */
    private $websiteId = '867132';

    /**
     * @see https://account.admitad.com/ru/webmaster/account/settings/credentials/
     */
    private $clientId = 'dada1b2f4773db527b54d22ba7f62b';
    private $clientSecret = '734aa2fe16ac507bf1eb7470dc87d0';

    public function __invoke()
    {
        try {
            DB::beginTransaction();

            $this->syncShops();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    private function syncShops(): void
    {
        $shops = Shop::all()->keyBy('outer_id');

        $this->fetchShopsFromApi()
            ->each(function ($shop_data) use ($shops) {
                $shop = $shops->pull($shop_data['outer_id']);
                if ($shop) {
                    $shop->fill($shop_data)->save();
                } else {
                    Shop::create($shop_data);
                }
            });

        if ($shops->isNotEmpty()) {
            Shop::destroy($shops->modelKeys());
        }
    }

    private function fetchShopsFromApi(): Collection
    {
        return collect($this->shops())->map(function ($shop) {
            return [
                'outer_id' => $shop['id'],
                'name' => $shop['name'],
                'site' => $shop['site_url'],
                'feed_url' => $shop['products_xml_link'],
            ];
        });
    }

    private function shops()
    {
        return Http::withToken($this->accessToken())
            ->withHeaders(['Accept-Encoding' => 'gzip'])
            ->get('https://api.admitad.com/advcampaigns/website/' . $this->websiteId . '/', [
                'limit' => 500,
                'connection_status' => 'active'
            ])
            ->json()['results'];
    }

    private function accessToken()
    {
        if (cache()->has(self::TOKEN_KEY)) {
            return cache()->get(self::TOKEN_KEY);
        }

        $data = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post('https://api.admitad.com/token/', [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'scope' => 'advcampaigns_for_website'
            ])
            ->json();

        cache()->put(self::TOKEN_KEY, $data['access_token'], $data['expires_in']);

        return $data['access_token'];
    }
}
