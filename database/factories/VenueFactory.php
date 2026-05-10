<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Venue>
 */
class VenueFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'thumbnail_path' => null,
            'is_published' => false,
            'cover_scene_id' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(['is_published' => true]);
    }
}
