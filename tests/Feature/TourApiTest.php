<?php

use App\Models\Scene;
use App\Models\Venue;

use function Pest\Laravel\getJson;

it('returns a list of published venues', function () {
    Venue::factory()->published()->count(3)->create();
    Venue::factory()->create(); // unpublished — should not appear

    getJson('/api/v1/venues')
        ->assertOk()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'slug', 'description', 'thumbnail_url', 'primary_color', 'scenes_count'],
            ],
        ]);
});

it('excludes unpublished venues from the list', function () {
    Venue::factory()->create(); // unpublished

    getJson('/api/v1/venues')
        ->assertOk()
        ->assertJsonCount(0, 'data');
});

it('returns venue detail with scenes and hotspots', function () {
    $venue = Venue::factory()->published()->create();
    Scene::factory()->for($venue)->count(2)->create();

    getJson("/api/v1/venues/{$venue->slug}")
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id', 'name', 'slug', 'description',
                'thumbnail_url', 'logo_url', 'primary_color',
                'scenes' => [
                    '*' => [
                        'id', 'name', 'image_url', 'audio_url',
                        'initial_yaw', 'initial_pitch', 'order',
                        'hotspots',
                    ],
                ],
            ],
        ])
        ->assertJsonCount(2, 'data.scenes');
});

it('returns 404 for an unknown venue slug', function () {
    getJson('/api/v1/venues/does-not-exist')
        ->assertNotFound()
        ->assertJson(['message' => 'Venue not found.']);
});

it('returns 404 for an unpublished venue', function () {
    $venue = Venue::factory()->create(); // unpublished

    getJson("/api/v1/venues/{$venue->slug}")
        ->assertNotFound();
});

it('excludes unpublished scenes from venue detail', function () {
    $venue = Venue::factory()->published()->create();
    Scene::factory()->for($venue)->count(2)->create();
    Scene::factory()->for($venue)->unpublished()->create();

    getJson("/api/v1/venues/{$venue->slug}")
        ->assertOk()
        ->assertJsonCount(2, 'data.scenes');
});
