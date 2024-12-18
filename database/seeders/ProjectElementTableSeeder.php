<?php

namespace Database\Seeders;

use App\Domains\ProjectManagement\Models\Project;
use App\Domains\ProjectManagement\Models\ProjectElement;
use Illuminate\Database\Seeder;

class ProjectElementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Project::where('id', '=', 1)
            ->firstOrFail();

        ProjectElement::factory()
            ->for($project)
            ->count(5)
            ->create();
    }
}
