<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\Link;
use Database\Seeders\BaseSeeder;
use Illuminate\Database\Seeder;

class LinkSeeder extends BaseSeeder
{
    public function run(): void
    {
        Link::factory($this->NB_LINKS)
            ->create();
    }
}
