<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageHelper extends Model
{
    use HasFactory;

    public static function saveImage($image, string $directory = 'avatars'): ?string
    {
        if ($image instanceof UploadedFile) {
            return $image->store($directory, 'public');
        }

        if (is_string($image) && str_starts_with($image, 'data:image')) {
            $imageParts = explode(';base64,', $image);
            if (count($imageParts) !== 2) {
                return null;
            }

            $imageType = str_replace('data:image/', '', $imageParts[0]);
            $imageData = base64_decode($imageParts[1]);

            if ($imageData === false) {
                return null;
            }

            $fileName = $directory . '/' . uniqid('img_', true) . '.' . $imageType;
            Storage::disk('public')->put($fileName, $imageData);

            return $fileName;
        }

        return null;
    }
}
