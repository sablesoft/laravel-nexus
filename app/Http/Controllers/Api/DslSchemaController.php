<?php

namespace App\Http\Controllers\Api;

use App\Logic\Effect\EffectDefinitionRegistry;
use Illuminate\Http\JsonResponse;

class DslSchemaController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'effects' => EffectDefinitionRegistry::toSchema(),
        ]);
    }
}
