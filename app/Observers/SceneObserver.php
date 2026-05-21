<?php

namespace App\Observers;

use App\Models\Scene;
use App\Services\StorageService;

class SceneObserver
{
    public function deleted(Scene $scene): void
    {
        $storage = app(StorageService::class);

        if ($scene->image_path) {
            $storage->delete($scene->image_path);
        }

        if ($scene->audio_path) {
            $storage->delete($scene->audio_path);
        }
    }
}
