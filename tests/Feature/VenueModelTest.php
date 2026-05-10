<?php

use App\Models\Hotspot;
use App\Models\Scene;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('auto-generates slug from name on create', function () {
    $venue = Venue::factory()->create(['name' => 'Gedung Sate Bandung', 'slug' => '']);

    expect($venue->slug)->toBe('gedung-sate-bandung');
});

it('has many scenes ordered by order column', function () {
    $venue = Venue::factory()->create();
    Scene::factory()->for($venue)->create(['order' => 2, 'name' => 'B']);
    Scene::factory()->for($venue)->create(['order' => 1, 'name' => 'A']);

    expect($venue->scenes->pluck('name')->toArray())->toBe(['A', 'B']);
});

it('belongs to a cover scene', function () {
    $venue = Venue::factory()->create();
    $scene = Scene::factory()->for($venue)->create();
    $venue->update(['cover_scene_id' => $scene->id]);

    expect($venue->fresh()->coverScene->id)->toBe($scene->id);
});

it('cover scene is nullified when scene is deleted', function () {
    $venue = Venue::factory()->create();
    $scene = Scene::factory()->for($venue)->create();
    $venue->update(['cover_scene_id' => $scene->id]);

    $scene->delete();

    expect($venue->fresh()->cover_scene_id)->toBeNull();
});

it('scenes are deleted when venue is deleted', function () {
    $venue = Venue::factory()->create();
    Scene::factory()->for($venue)->count(3)->create();

    $venue->delete();

    expect(Scene::count())->toBe(0);
});

it('scene has many hotspots', function () {
    $scene = Scene::factory()->create();
    Hotspot::factory()->for($scene)->count(2)->create();

    expect($scene->hotspots)->toHaveCount(2);
});

it('hotspot target scene is nullified when target scene is deleted', function () {
    $scene = Scene::factory()->create();
    $targetScene = Scene::factory()->for($scene->venue)->create();
    $hotspot = Hotspot::factory()->sceneLink($targetScene)->for($scene)->create();

    $targetScene->delete();

    expect($hotspot->fresh()->target_scene_id)->toBeNull();
});

it('hotspots are deleted when scene is deleted', function () {
    $scene = Scene::factory()->create();
    Hotspot::factory()->for($scene)->count(3)->create();

    $scene->delete();

    expect(Hotspot::count())->toBe(0);
});
