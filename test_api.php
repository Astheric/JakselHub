<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$response = \Illuminate\Support\Facades\Http::get('https://air-quality-api.open-meteo.com/v1/air-quality', [
    'latitude' => -6.2615,
    'longitude' => 106.8106,
    'current' => 'us_aqi'
]);

echo $response->body();
