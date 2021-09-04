<?php

namespace App\Console\Commands;

use App\Services\ImportOffers;
use App\Models\Shop;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'import';

    protected $description = 'Import offers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(ImportOffers $importOffers)
    {
        $shop_ids = $this->argument('shop_id');
        $shops = $shop_ids ? Shop::whereIn('id', $shop_ids)->get() : Shop::all() ;
        $shops->each(fn($shop) => $importOffers->handle($shop));

        return 0;
    }
}
