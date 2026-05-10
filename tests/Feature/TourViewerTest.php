<?php

use App\Models\Scene;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('home page shows published venues', function () {
    Venue::factory()->published()->count(3)->create();
    Venue::factory()->count(2)->create(); // unpublished

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewHas('venues', fn ($venues) => $venues->count() === 3);
});

it('home page shows empty state when no published venues', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertViewHas('venues', fn ($venues) => $venues->isEmpty());
});

it('tour page loads for published venue', function () {
    $venue = Venue::factory()->published()->create();
    Scene::factory()->for($venue)->count(2)->create();

    $response = $this->get(route('tour', $venue));

    $response->assertOk();
    $response->assertSee($venue->name);
});

it('tour page returns 404 for unpublished venue', function () {
    $venue = Venue::factory()->create(['is_published' => false]);

    $response = $this->get(route('tour', $venue));

    $response->assertNotFound();
});

it('tour page returns 404 for unknown slug', function () {
    $this->get('/tour/tidak-ada-venue')->assertNotFound();
});

it('tour page only shows published scenes', function () {
    $venue = Venue::factory()->published()->create();
    Scene::factory()->for($venue)->create(['name' => 'Scene Tampil', 'is_published' => true]);
    Scene::factory()->for($venue)->create(['name' => 'Scene Tersembunyi', 'is_published' => false]);

    $response = $this->get(route('tour', $venue));

    $response->assertOk();
    $response->assertSee('Scene Tampil');
    $response->assertDontSee('Scene Tersembunyi');
});
