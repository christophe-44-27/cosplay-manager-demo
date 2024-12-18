<?php

namespace Database\Factories\Domains\ProjectManagement\Models;

use App\Domains\ProjectManagement\Models\ProjectElement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\ProjectManagement\Models\ProjectElement>
 */
class ProjectElementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = ProjectElement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'price' => $this->faker->randomFloat(2, 00.00, 100.00),
            'is_done' => $this->faker->boolean
        ];
    }
}
