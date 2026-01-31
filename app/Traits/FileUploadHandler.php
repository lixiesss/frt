<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileUploadHandler
{
    /**
     * Upload a file to storage
     */
    protected function uploadFile(UploadedFile $file, string $directory, ?string $filename = null, string $disk = 'public'): string
    {
        $filename = $filename ?? time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        
        return $file->storePubliclyAs($directory, $filename, $disk);
    }

    /**
     * Delete a file from storage
     */
    protected function deleteFile(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Get file URL
     */
    protected function getFileUrl(string $path, string $disk = 'public'): string
    {
        return Storage::disk($disk)->url($path);
    }

    /**
     * Upload CV with specific naming
     */
    protected function uploadCV(UploadedFile $cv, string $name, string $nrp): string
    {
        $filename = 'CV_' . $name . '_' . $nrp . '.' . $cv->extension();
        return $this->uploadFile($cv, 'cv', $filename);
    }

    /**
     * Upload portfolio with specific naming
     */
    protected function uploadPortfolio(UploadedFile $portfolio, string $nrp, int $priority): string
    {
        $filename = 'portfolio_' . $priority . '_' . $nrp . '.' . $portfolio->extension();
        return $this->uploadFile($portfolio, 'portfolios', $filename);
    }

    /**
     * Upload coding answer
     */
    protected function uploadCodingAnswer(UploadedFile $file, string $nrp): string
    {
        $filename = time() . '_' . $nrp . '_' . $file->getClientOriginalName();
        return $this->uploadFile($file, 'uploads/answers', $filename);
    }

    /**
     * Upload coding question image
     */
    protected function uploadCodingQuestionImage(UploadedFile $image): string
    {
        $filename = time() . '_' . $image->getClientOriginalName();
        return $this->uploadFile($image, 'uploads/codingQuiz', $filename);
    }

    /**
     * Upload department quiz answer
     */
    protected function uploadDepartmentAnswer(UploadedFile $file, string $nrp): string
    {
        $filename = time() . '_' . $nrp . '.' . $file->extension();
        return $this->uploadFile($file, 'quiz_answers', $filename);
    }
}
