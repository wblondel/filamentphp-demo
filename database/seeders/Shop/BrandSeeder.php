<?php

namespace Database\Seeders\Shop;

use App\Models\Address;
use App\Models\Shop\Brand as ShopBrand;
use Database\Seeders\BaseSeeder;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Seeder;

class BrandSeeder extends BaseSeeder
{
    public function run(): void
    {
        ShopBrand::factory()->count($this->NB_BRANDS)
            ->has(Address::factory()->count(rand($this->NB_MIN_ADDRESSES_PER_BRAND, $this->NB_MAX_ADDRESSES_PER_BRAND)))
            ->create();

        ShopBrand::query()->update([
            'sort' => new Expression('id')
        ]);
    }
}
