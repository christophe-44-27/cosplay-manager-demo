<?php

namespace Database\Seeders;

use App\Domains\Core\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->createMany([
            [
                'name' => "Catégorie1",
            ],
            [
                'name' => "Catégorie2",
            ],
            [
                'name' => "Catégorie3",
            ],
            [
                'name' => "Catégorie4",
            ],
            [
                'name' => "Catégorie5",
            ],
            [
                'name' => "Catégorie6",
            ]
        ]);
    }
}
