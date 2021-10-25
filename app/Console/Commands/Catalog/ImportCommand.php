<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\ImportOffersAction;
use App\Models\Shop;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'catalog:import {shop_id?* : список id магазинов}';

    protected $description = 'Импорт товаров в каталог';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ImportOffersAction $importOffersAction)
    {
        $shopIds = $this->argument('shop_id');
        $query = Shop::active();
        $shops = $shopIds ? $query->whereIn('id', $shopIds)->get() : $query->get() ;

        $shops->each(fn($shop) => $importOffersAction($shop));

        return 0;
    }
}
