<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        User::query()->truncate();
        Category::query()->truncate();
        Product::query()->truncate();
        Transaction::query()->truncate();
        DB::table('category_product')->truncate();

        User::flushEventListeners();

        User::factory(200)->create();
        Category::factory(30)->create();
        Product::factory(1000)->create()->each(
            function ($product) {
                $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );
        Transaction::factory(1000)->create();
    }
}
