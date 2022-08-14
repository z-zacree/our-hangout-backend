<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->count(6)->create();

        User::factory()
            ->count(10)
            ->has(
                Post::factory()
                    ->count(2)
                    ->hasPostCategories(1)
            )->create();
    }
}
