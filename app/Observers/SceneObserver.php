<?php

namespace App\Observers;

use App\Models\Scene;
use App\Services\StorageService;

class SceneObserver
{
    public function deleted(Scene $scene): void
    {
        if ($scene->image_path) {
            app(StorageService::class)->delete($scene->image_path);
        }
    }
}
