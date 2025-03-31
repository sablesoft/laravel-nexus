<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DslSchemaController;

Route::get('/dsl/schema', DslSchemaController::class)->name('dsl.schema');
