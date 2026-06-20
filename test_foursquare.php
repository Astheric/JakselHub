<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$apiKey = env('FOURSQUARE_API_KEY');
echo "API Key length: " . strlen($apiKey) . "\n";

$url = 'https://api.foursquare.com/v3/places/search?near=South%20Jakarta,%20ID&categories=16032,10027,16020,10001,10032&fields=fsq_id,name,location,categories,photos,description,geocodes&limit=5';
echo "Fetching: $url\n";

$options = [
    'http' => [
        'method' => 'GET',
        'header' => "Authorization: $apiKey\r\nAccept: application/json\r\n"
    ]
];
$context = stream_context_create($options);

$response = @file_get_contents($url, false, $context);
if ($response === false) {
    echo "HTTP Request Failed.\n";
    print_r(error_get_last());
} else {
    $data = json_decode($response, true);
    if (isset($data['results'])) {
        echo "Found " . count($data['results']) . " results.\n";
        foreach ($data['results'] as $res) {
            echo "- " . $res['name'] . " (Categories: ";
            $cats = [];
            foreach ($res['categories'] ?? [] as $c) {
                $cats[] = $c['id'];
            }
            echo implode(", ", $cats) . ")\n";
        }
    } else {
        echo "No results key. Response: \n$response\n";
    }
}
