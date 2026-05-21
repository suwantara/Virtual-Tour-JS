<?php

namespace App\Livewire;

use App\Models\Venue;
use App\Services\SceneService;
use App\Services\StorageService;
use Illuminate\View\View;
use Livewire\Component;

class TourViewer extends Component
{
    public Venue $venue;

    public function mount(Venue $venue): void
    {
        abort_unless($venue->is_published, 404);
    }

    public function render(SceneService $sceneService, StorageService $storage): View
    {
        $scenes = $sceneService->getScenesForViewer($this->venue);

        $thumbnailUrl = $this->venue->thumbnail_path
            ? $storage->getUrl($this->venue->thumbnail_path)
            : null;

        $description = $this->venue->description
            ?? 'Jelajahi virtual tour 360° warisan budaya di '.config('app.name');

        return view('livewire.tour-viewer', [
            'scenes' => $scenes,
            'primaryColor' => $this->venue->primary_color ?? '#9A8678',
            'logoUrl' => $this->venue->logo_path
                ? $storage->getUrl($this->venue->logo_path)
                : null,
        ])->layout('layouts.public', [
            'title' => $this->venue->name.' — '.config('app.name'),
            'metaDescription' => $description,
            'ogTitle' => $this->venue->name,
            'ogDescription' => $description,
            'ogImage' => $thumbnailUrl,
            'ogType' => 'website',
            'canonicalUrl' => route('tour', $this->venue->slug),
        ]);
    }
}
