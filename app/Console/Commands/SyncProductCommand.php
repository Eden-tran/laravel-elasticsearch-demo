<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Jobs\SyncProductToElasticsearch;

class SyncProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:sync {--chunk= : Number of records to process per batch (leave empty to sync all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all products from database to Elasticsearch';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $chunkSize = (int) $this->option('chunk') ?: null; // If no chunk is provided, set to null

        if ($chunkSize) {
            $this->info("Syncing products in chunks of {$chunkSize}...");
            Product::query()->chunk($chunkSize, function ($products) {
                foreach ($products as $product) {
                    SyncProductToElasticsearch::dispatch($product);
                }
            });
        } else {
            $this->info("Syncing all products at once...");
            $products = Product::all();
            foreach ($products as $product) {
                $product = $product->toArray();
                SyncProductToElasticsearch::dispatch($product);
            }
        }

        $this->info("Product sync job dispatched.");
    }
}
