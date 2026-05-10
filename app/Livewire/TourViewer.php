<?php

namespace App\Livewire;

use App\Models\Venue;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;

class TourViewer extends Component
{
    public Venue $venue;

    public function mount(Venue $venue): void
    {
        abort_unless($venue->is_published, 404);
    }

    public function render(): View
    {
        $scenes = $this->venue
            ->scenes()
            ->where('is_published', true)
            ->with('hotspots')
            ->orderBy('order')
            ->get()
            ->map(fn ($scene) => [
                'id' => $scene->id,
                'name' => $scene->name,
                'image_path' => $scene->image_path
                    ? $this->resolveUrl($scene->image_path)
                    : null,
                'initial_yaw' => $scene->initial_yaw,
                'initial_pitch' => $scene->initial_pitch,
                'hotspots' => $scene->hotspots->map(fn ($hs) => [
                    'id' => $hs->id,
                    'type' => $hs->type,
                    'label' => $hs->label,
                    'description' => $hs->description,
                    'pitch' => $hs->pitch,
                    'yaw' => $hs->yaw,
                    'target_scene_id' => $hs->target_scene_id,
                    'url' => $hs->url,
                    'media_url' => $hs->media_url,
                    'media_type' => $hs->media_type,
                ])->values()->all(),
            ])
            ->values();

        return view('livewire.tour-viewer', [
            'scenes'       => $scenes,
            'primaryColor' => $this->venue->primary_color ?? '#9A8678',
            'logoUrl'      => $this->venue->logo_path
                ? $this->resolveUrl($this->venue->logo_path)
                : null,
        ])->layout('layouts.public', [
            'title' => $this->venue->name.' — '.config('app.name'),
        ]);
    }

    private function resolveUrl(string $path): string
    {
        if (app()->isLocal()) {
            return route('r2.proxy', ['path' => $path]);
        }

        try {
            return Storage::disk('r2')->url($path);
        } catch (\RuntimeException) {
            return asset('storage/'.$path);
        }
    }
}
