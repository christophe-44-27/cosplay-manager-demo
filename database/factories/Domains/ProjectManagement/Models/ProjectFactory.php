<?php

namespace Database\Factories\Domains\ProjectManagement\Models;

use App\Domains\ProjectManagement\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\ProjectManagement\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'description' => fake()->text,
            'is_private' => fake()->boolean,
            'slug' => Str::slug($title),
            'project_estimated_price' => fake()->randomFloat(2, 10.00, 1250.00),
        ];
    }
}
