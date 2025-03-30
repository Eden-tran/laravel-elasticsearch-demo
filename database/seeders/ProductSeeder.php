<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Jobs\SyncProductToElasticsearch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = (int) (request()->input('number', 1000)); // Get number from command option, default 1000
        $this->command->info("Seeding {$count} products...");

        $faker = Faker::create();
        $products = [];

        for ($i = 0; $i < $count; $i++) {
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

        $this->command->info("Successfully seeded {$count} products!");
    }
}
