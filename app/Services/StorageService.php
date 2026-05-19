<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageService
{
    public function upload(UploadedFile $file, string $folder): string
    {
        return Storage::disk('r2')->put($folder, $file);
    }

    public function getUrl(string $path): string
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

    public function delete(string $path): void
    {
        Storage::disk('r2')->delete($path);
    }

    public function replace(string $oldPath, UploadedFile $newFile, string $folder): string
    {
        $this->delete($oldPath);

        return $this->upload($newFile, $folder);
    }
}
