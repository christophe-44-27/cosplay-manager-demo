<?php

namespace Database\Factories\Domains\Core\Models;

use App\Domains\Core\Models\UserSocialProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Core\Models\UserSocialProfile>
 */
class UserSocialProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = UserSocialProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'facebook_id' => fake()->word,
            'twitter_id' => fake()->word,
            'instagram_id' => fake()->word,
            'youtube_id' => fake()->word,
            'twitch_id' => fake()->word,
        ];
    }
}
