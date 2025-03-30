<?php

namespace App\Jobs;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;


class SeedProductsJob implements ShouldQueue
{
    use Queueable;

    protected $count;

    /**
     * Create a new job instance.
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $faker = Faker::create();
        $batchSize = 1000; // Insert in chunks

        DB::beginTransaction();
        try {
            for ($i = 0; $i < ceil($this->count / $batchSize); $i++) {
                $products = [];

                for ($j = 0; $j < min($batchSize, $this->count - ($i * $batchSize)); $j++) {
                    $products[] = [
                        'name' => $faker->word,
                        'description' => $faker->sentence,
                        'price' => $faker->randomFloat(2, 10, 1000),
                        'stock' => $faker->numberBetween(1, 500),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                Product::insert($products);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Seeding failed: " . $e->getMessage());
        }
    }
}
