<?php

namespace Database\Seeders;

use Database\Seeders\Blog\AuthorAndPostSeeder;
use Database\Seeders\Shop\CategorySeeder as ShopCategorySeeder;
use Database\Seeders\Blog\CategorySeeder as BlogCategorySeeder;
use Database\Seeders\Blog\LinkSeeder;
use Database\Seeders\Shop\BrandSeeder;
use Database\Seeders\Shop\CustomerSeeder;
use Database\Seeders\Shop\OrderSeeder;
use Database\Seeders\Shop\ProductSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::disableQueryLog();
        DB::raw('SET time_zone=\'+00:00\'');

        $filamentFilesystemDisk = config('filament.default_filesystem_disk');

        // Clear images
        foreach (Storage::disk($filamentFilesystemDisk)->allDirectories() as $directory) {
            Storage::disk($filamentFilesystemDisk)->deleteDirectory($directory);
        }

        foreach (Storage::disk($filamentFilesystemDisk)->allFiles() as $file) {
            Storage::disk($filamentFilesystemDisk)->delete($file);
        }

        $this->call([
            UserSeeder::class,
            // Shop
            BrandSeeder::class,
            ShopCategorySeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            // Blog
            BlogCategorySeeder::class,
            AuthorAndPostSeeder::class,
            LinkSeeder::class,
        ]);

        DB::enableQueryLog();
    }
}
