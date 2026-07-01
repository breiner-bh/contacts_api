<?php

use App\Http\Controllers\contacts;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Route::apiResource('contacts',contacts::class)->middleware('auth:sanctum');