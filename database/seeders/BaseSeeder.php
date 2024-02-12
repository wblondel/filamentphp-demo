<?php

namespace Database\Seeders;

use Closure;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class BaseSeeder extends Seeder {
    // Blog
    protected int $NB_AUTHORS = 10;
    protected int $NB_MIN_POSTS_PER_AUTHOR = 5;
    protected int $NB_MAX_POSTS_PER_AUTHOR = 200;
    protected int $NB_MIN_COMMENTS_PER_POST = 5;
    protected int $NB_MAX_COMMENTS_PER_POST = 200;
    protected int $NB_BLOG_CATEGORIES = 20;
    protected int $NB_LINKS = 200;

    // Shop
    protected int $NB_BRANDS = 2_000;
    protected int $NB_MIN_ADDRESSES_PER_BRAND = 1;
    protected int $NB_MAX_ADDRESSES_PER_BRAND = 3;
    protected int $NB_SHOP_CATEGORIES = 1_000;
    protected int $NB_SHOP_CATEGORIES_PER_SHOP_CATEGORY = 3;
    protected int $NB_CUSTOMERS =  1_000;
    protected int $NB_MIN_ADDRESSES_PER_CUSTOMER = 1;
    protected int $NB_MAX_ADDRESSES_PER_CUSTOMER = 3;
    protected int $NB_ORDERS = 1_000_000;
    protected int $NB_MIN_PAYMENTS_PER_ORDER = 1;
    protected int $NB_MAX_PAYMENTS_PER_ORDER = 3;
    protected int $NB_MIN_ORDER_ITEMS_PER_ORDER = 1;
    protected int $NB_MAX_ORDER_ITEMS_PER_ORDER = 8;
    protected int $NB_PRODUCTS = 10_000;
    protected int $NB_MIN_SHOP_CATEGORIES_PER_PRODUCT = 3;
    protected int $NB_MAX_SHOP_CATEGORIES_PER_PRODUCT = 6;
    protected int $NB_MIN_COMMENTS_PER_PRODUCT = 0;
    protected int $NB_MAX_COMMENTS_PER_PRODUCT = 200;

    protected function withProgressBar(int $steps, Closure $createCollectionOfOne, int $amountPerStep = 1): void
    {
        $progressBar = new ProgressBar($this->command->getOutput(), $steps * $amountPerStep);

        $progressBar->start();

        foreach (range(1, $steps) as $i) {
            $createCollectionOfOne();
            $progressBar->advance($amountPerStep);
        }

        $progressBar->finish();

        $this->command->getOutput()->writeln('');
    }
}
