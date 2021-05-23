<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Shop::create([
            'name' => 'Kupivip RU',
            'site' => 'https://kupivip.ru/',
            'feed_url' => 'https://export.admitad.com/ru/webmaster/websites/867132/products/export_adv_products/?currency=&code=ad111e335d&user=mastersuper&format=xml&feed_id=153&last_import='
        ]);

        Shop::create([
            'name' => 'Elyts',
            'site' => 'https://elyts.ru/',
            'feed_url' => 'https://export.admitad.com/ru/webmaster/websites/867132/products/export_adv_products/?currency=&code=ad111e335d&user=mastersuper&format=xml&feed_id=15201&last_import='
        ]);
    }
}
