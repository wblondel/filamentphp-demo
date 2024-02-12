<?php

namespace Database\Seeders\Shop;

use App\Models\Comment;
use App\Models\Shop\Brand;
use App\Models\Shop\Category;
use App\Models\Shop\Customer;
use App\Models\Shop\Product;
use Database\Seeders\BaseSeeder;
use Illuminate\Database\Seeder;

class ProductSeeder extends BaseSeeder
{
    public function run(): void
    {
        $categories = Category::select('id')->get();

        $brandIds = Brand::select('id')->pluck('id');
        $customerIds = Customer::select('id')->pluck('id');

        $amountPerStep = 100;
        $steps = $this->NB_PRODUCTS / $amountPerStep;

        $this->withProgressBar($steps, function() use ($customerIds, $brandIds, $categories, $amountPerStep) {
            Product::factory($amountPerStep)
                ->sequence(fn ($sequence) => ['shop_brand_id' => $brandIds->random()])
                ->hasAttached($categories->random(rand($this->NB_MIN_SHOP_CATEGORIES_PER_PRODUCT, $this->NB_MAX_SHOP_CATEGORIES_PER_PRODUCT)), [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
                ->has(
                    Comment::factory()->count(rand($this->NB_MIN_COMMENTS_PER_PRODUCT, $this->NB_MAX_COMMENTS_PER_PRODUCT))
                        ->state(fn (array $attributes, Product $product) => [
                            'customer_id' => $customerIds->random()
                        ]),
                )
                ->create();
        }, $amountPerStep);
    }
}
