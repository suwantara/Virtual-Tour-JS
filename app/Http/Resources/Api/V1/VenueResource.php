<?php

namespace App\Http\Resources\Api\V1;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VenueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $storage = app(StorageService::class);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'thumbnail_url' => $this->thumbnail_path ? $storage->getUrl($this->thumbnail_path) : null,
            'logo_url' => $this->logo_path ? $storage->getUrl($this->logo_path) : null,
            'primary_color' => $this->primary_color,
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),
            'scenes_count' => $this->whenCounted('scenes'),
            'scenes' => SceneResource::collection($this->whenLoaded('scenes')),
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
