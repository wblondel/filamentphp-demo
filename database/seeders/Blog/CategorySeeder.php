<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\Category;
use Database\Seeders\BaseSeeder;
use Illuminate\Database\Seeder;

class CategorySeeder extends BaseSeeder
{
    public function run(): void
    {
        Category::factory($this->NB_BLOG_CATEGORIES)
            ->create();
    }
}
