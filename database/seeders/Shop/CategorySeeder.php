<?php

namespace Database\Seeders\Shop;

use App\Models\Shop\Category;
use Database\Seeders\BaseSeeder;
use Illuminate\Database\Seeder;

class CategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        Category::factory($this->NB_SHOP_CATEGORIES)
            ->has(
                Category::factory()->count($this->NB_SHOP_CATEGORIES_PER_SHOP_CATEGORY),
                'children'
            )->create();
    }
}
