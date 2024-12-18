<?php

namespace Database\Seeders;

use App\Domains\Core\Models\Category;
use App\Domains\ProjectManagement\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::where('name', '=', 'Catégorie1')->firstOrFail();
        $user = User::where('email', '=', 'admin@admin.com')->firstOrFail();

        Project::factory()
            ->for($category)
            ->for($user)
            ->count(10)
            ->create();
    }
}
