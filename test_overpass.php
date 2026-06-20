<?php
$query = '[out:json][timeout:25];
area["name"="Jakarta Selatan"]->.searchArea;
(
  node["leisure"="park"](area.searchArea);
  way["leisure"="park"](area.searchArea);
);
out center 10;';

$options = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: JakselHubBot/1.0\r\n"
    ]
];
$context = stream_context_create($options);

$url = 'https://overpass-api.de/api/interpreter?data=' . urlencode($query);
$response = file_get_contents($url, false, $context);
echo $response;
