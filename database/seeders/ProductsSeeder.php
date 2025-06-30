<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 25; $i++) {
            $price = $faker->numberBetween(5, 30);
            $discount = $faker->numberBetween(5, 50);
            $afterDiscountPrice = $price - ($price * $discount / 100);
            $stock = $faker->numberBetween(10, 100); // or any logic

            Products::create([
                'title' => $faker->word,
                'description' => $faker->sentence,
                'image' => $faker->imageUrl(320, 240),
                'price' => $price,
                'discount' => $discount,
                'stock' => $stock,
                'store_category' => $faker->word,
                'user_category' => $faker->word,
                'after_dis_price' => round($afterDiscountPrice, 2),
            ]);
        }
    }
}
