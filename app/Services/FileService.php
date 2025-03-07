<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Interfaces\HasFilesInterface;

class FileService
{
    /**
     * @param HasFilesInterface $model
     * @return void
     */
    public static function remove(HasFilesInterface $model): void
    {
        foreach ($model->getPaths() as $path) {
            Storage::delete($path);
        }
    }

    /**
     * @param HasFilesInterface $model
     * @return void
     * @throws \Exception
     */
    public static function check(HasFilesInterface $model): void
    {
        foreach ($model->getPaths() as $path) {
            if (!Storage::has($path)) {
                throw new \Exception('File not found in path: ' . $path);
            }
        }
    }
}
