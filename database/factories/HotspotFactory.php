<?php

namespace Database\Factories;

use App\Models\Hotspot;
use App\Models\Scene;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotspot>
 */
class HotspotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'scene_id' => Scene::factory(),
            'type' => fake()->randomElement(['scene_link', 'info', 'url', 'media']),
            'label' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'pitch' => fake()->randomFloat(2, -90, 90),
            'yaw' => fake()->randomFloat(2, -180, 180),
            'target_scene_id' => null,
            'url' => null,
            'media_url' => null,
            'media_type' => null,
        ];
    }

    public function sceneLink(Scene $targetScene): static
    {
        return $this->state([
            'type' => 'scene_link',
            'target_scene_id' => $targetScene->id,
        ]);
    }

    public function info(): static
    {
        return $this->state(['type' => 'info']);
    }

    public function externalUrl(): static
    {
        return $this->state([
            'type' => 'url',
            'url' => fake()->url(),
        ]);
    }

    public function media(string $mediaType = 'video'): static
    {
        return $this->state([
            'type' => 'media',
            'media_url' => fake()->url(),
            'media_type' => $mediaType,
        ]);
    }
}
