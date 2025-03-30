<?php

namespace App\Console\Commands;

use App\Models\Product;
use Faker\Factory as Faker;
use App\Jobs\SeedProductsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class SeedProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:seed {--number=1000}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the product seeder with a specified number of records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) $this->option('number', 1000);
        $this->info("Queueing seed job for {$count} products...");

        SeedProductsJob::dispatch($count);

        $this->info("Job dispatched! Run `php artisan queue:work` to process.");
    }
}
