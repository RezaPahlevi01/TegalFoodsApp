<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    private ?string $cloudName;
    private ?string $uploadPreset;

    public function __construct()
    {
        $this->cloudName = config('services.cloudinary.cloud_name');
        $this->uploadPreset = config('services.cloudinary.upload_preset');
    }

    public function upload(UploadedFile $file, string $folder = 'qris'): ?string
    {
        if (empty($this->cloudName) || empty($this->uploadPreset)) {
            Log::warning('Cloudinary not configured.');
            return null;
        }

        $dataUri = 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->get());

        $response = Http::attach(
            'file', $dataUri
        )->post("https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload", [
            'upload_preset' => $this->uploadPreset,
            'folder' => $folder,
        ]);

        if ($response->successful()) {
            return $response->json('secure_url');
        }

        Log::warning('Cloudinary upload failed.', [
            'status' => $response->status(),
            'error' => $response->body(),
        ]);

        return null;
    }
}
