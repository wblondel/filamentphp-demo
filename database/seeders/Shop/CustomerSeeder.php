<?php

namespace Database\Seeders\Shop;

use App\Models\Address;
use App\Models\Shop\Customer;
use Database\Seeders\BaseSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class CustomerSeeder extends BaseSeeder
{
    public function run(): void
    {
        $amountPerStep = 1_000;
        $steps = $this->NB_CUSTOMERS / $amountPerStep;

        $this->withProgressBar($steps, function () use ($amountPerStep) {
            Customer::factory($amountPerStep)
                ->has(Address::factory()->count(rand($this->NB_MIN_ADDRESSES_PER_CUSTOMER, $this->NB_MAX_ADDRESSES_PER_CUSTOMER)))
                ->create();
        }, $amountPerStep);
    }
}
