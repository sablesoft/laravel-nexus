<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
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
        foreach ($model->getPathAttributes() as $attribute) {
            Storage::delete($model->$attribute);
        }
    }

    public static function update(HasFilesInterface|Model $model): void
    {
        foreach ($model->getPathAttributes() as $attribute) {
            $original = $model->getOriginal($attribute);
            if ($original && !$model->originalIsEquivalent($attribute)) {
                Storage::delete($original);
            }
        }
    }

    /**
     * @param HasFilesInterface $model
     * @return void
     * @throws \Exception
     */
    public static function check(HasFilesInterface $model): void
    {
        foreach ($model->getPathAttributes() as $attribute) {
            if ($model->$attribute && !Storage::has($model->$attribute)) {
                throw new \Exception('File for attribute ' . $attribute . ' with path '. $model->$attribute . ' not found!');
            }
        }
    }
}
