<?php

namespace App\Models\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

class StoreService
{
    /**
     * @param array $data
     * @param Model $model
     * @return Model
     * @throws Throwable
     */
    public static function handle(array $data, Model $model): Model
    {
        foreach($data as $field => $value) {
            $model->$field = $value;
        }

        try {
            DB::beginTransaction();
            $model->save();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $model;
    }
}
