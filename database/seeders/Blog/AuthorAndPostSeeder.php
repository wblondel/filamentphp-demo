<?php

namespace Database\Seeders\Blog;

use App\Models\Blog\Author;
use App\Models\Blog\Category;
use App\Models\Blog\Post;
use App\Models\Comment;
use App\Models\Shop\Customer;
use Database\Seeders\BaseSeeder;

class AuthorAndPostSeeder extends BaseSeeder
{
    public function run(): void
    {
        $blogCategoryIds = Category::select('id')->pluck('id');
        $customerIds = Customer::select('id')->pluck('id');

        Author::factory($this->NB_AUTHORS)
            ->has(
                Post::factory()->count(rand($this->NB_MIN_POSTS_PER_AUTHOR, $this->NB_MAX_POSTS_PER_AUTHOR))
                    ->has(
                        Comment::factory()->count(rand($this->NB_MIN_COMMENTS_PER_POST, $this->NB_MAX_COMMENTS_PER_POST))
                            ->state(fn (array $attributes, Post $post) => ['customer_id' => $customerIds->random()]),
                    )
                    ->state(fn (array $attributes, Author $author) => ['blog_category_id' => $blogCategoryIds->random()]),
                'posts'
            )
            ->create();
    }
}
