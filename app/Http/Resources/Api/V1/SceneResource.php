<?php

namespace App\Http\Resources\Api\V1;

use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SceneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $storage = app(StorageService::class);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'local_name' => $this->local_name,
            'description' => $this->description,
            'era' => $this->era,
            'material' => $this->material,
            'ritual_function' => $this->ritual_function,
            'image_url' => $this->image_path ? $storage->getUrl($this->image_path) : null,
            'audio_url' => $this->audio_path ? $storage->getUrl($this->audio_path) : null,
            'initial_yaw' => $this->initial_yaw,
            'initial_pitch' => $this->initial_pitch,
            'order' => $this->order,
            'hotspots' => HotspotResource::collection($this->whenLoaded('hotspots')),
        ];
    }
}
