<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesImageUploads
{
    /**
     * Resolve an image to a URL: an uploaded file wins over a pasted URL,
     * and when neither is given the existing value is kept.
     */
    protected function resolveImageUrl(
        Request $request,
        string $fileInput,
        string $urlInput,
        string $directory,
        ?string $existing = null
    ): ?string {
        if ($request->hasFile($fileInput) && $request->file($fileInput)->isValid()) {
            $this->deleteUploadedImage($existing);
            $path = $request->file($fileInput)->store($directory, 'public');

            return '/storage/' . $path;
        }

        $url = $request->input($urlInput);

        return $url ?: $existing;
    }

    /** Remove a file we uploaded ourselves; external URLs are left alone. */
    protected function deleteUploadedImage(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/')) {
            Storage::disk('public')->delete(ltrim(str_replace('/storage', '', $url), '/'));
        }
    }
}
