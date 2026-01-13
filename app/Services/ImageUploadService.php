<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload image ke storage
     * 
     * @param UploadedFile $file
     * @param string $path
     * @return string|null
     */
    public static function upload(UploadedFile $file, string $path = 'products'): ?string
    {
        try {
            if (!$file) {
                return null;
            }

            // Generate nama file unik
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Simpan ke storage/app/public/
            $filePath = $file->storeAs($path, $filename, 'public');
            
            return $filePath;
        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete image dari storage
     * 
     * @param string|null $filePath
     * @return bool
     */
    public static function delete(?string $filePath): bool
    {
        try {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            \Log::error('Image delete failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get full URL untuk image
     * 
     * @param string|null $filePath
     * @return string
     */
    public static function getUrl(?string $filePath): string
    {
        if (!$filePath) {
            return 'https://via.placeholder.com/300?text=No+Image';
        }

        return asset('storage/' . $filePath);
    }
}
