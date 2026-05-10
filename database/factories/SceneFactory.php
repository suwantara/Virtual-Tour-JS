<?php

namespace Database\Factories;

use App\Models\Scene;
use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Scene>
 */
class SceneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'venue_id' => Venue::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'image_path' => null,
            'initial_yaw' => fake()->randomFloat(2, -180, 180),
            'initial_pitch' => fake()->randomFloat(2, -90, 90),
            'order' => fake()->numberBetween(0, 10),
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['is_published' => false]);
    }
}
