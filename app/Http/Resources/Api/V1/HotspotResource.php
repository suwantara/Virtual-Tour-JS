<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotspotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'label' => $this->label,
            'description' => $this->description,
            'pitch' => $this->pitch,
            'yaw' => $this->yaw,
            'target_scene_id' => $this->target_scene_id,
            'url' => $this->url,
            'media_url' => $this->media_url,
            'media_type' => $this->media_type,
        ];
    }
}
