<?php

namespace App\Services\Feed;

use App\Models\Shop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SyncShops
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

    public function run()
    {
        try {
            DB::beginTransaction();
            $shops = Shop::all()->keyBy('outer_id');

            $this->fetch()->each(function ($campaign) use ($shops) {
                if (!$shops->has($campaign['outer_id'])) {
                    Shop::create($campaign);
                    return;
                }

                $shops->pull($campaign['outer_id'])
                    ->fill($campaign)
                    ->save();
            });

            if ($shops->isNotEmpty()) {
                Shop::destroy($shops->modelKeys());
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function fetch(): Collection
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
