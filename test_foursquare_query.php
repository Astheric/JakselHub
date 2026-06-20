<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('FOURSQUARE_API_KEY');

$url = 'https://api.foursquare.com/v3/places/search?near=South%20Jakarta,%20ID&query=park&fields=fsq_id,name,location,categories,photos,description,geocodes&limit=5';
echo "Fetching: $url\n";

$options = [
    'http' => [
        'method' => 'GET',
        'ignore_errors' => true,
        'header' => "Authorization: $apiKey\r\nAccept: application/json\r\n"
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);
echo "Response:\n$response\n";
