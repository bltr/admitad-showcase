<?php

namespace App\Console\Commands\Catalog;

use App\Services\Catalog\ImportOffers;
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

    public function handle(ImportOffers $importOffers)
    {
        $shop_ids = $this->argument('shop_id');
        $query = Shop::approved();
        $shops = $shop_ids ? $query->whereIn('id', $shop_ids)->get() : $query->get() ;

        $shops->each(fn($shop) => $importOffers->run($shop));

        return 0;
    }
}
