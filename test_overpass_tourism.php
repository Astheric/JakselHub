<?php
$query = '[out:json][timeout:25];
area["name"="Jakarta Selatan"]->.searchArea;
(
  node["tourism"~"museum|attraction|theme_park|zoo"]["name"](area.searchArea);
  way["tourism"~"museum|attraction|theme_park|zoo"]["name"](area.searchArea);
  node["historic"~"monument|memorial|ruins|castle|yes"]["name"](area.searchArea);
  way["historic"~"monument|memorial|ruins|castle|yes"]["name"](area.searchArea);
);
out center;';

$options = [
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: JakselHubBot/1.0\r\n"
    ]
];
$context = stream_context_create($options);

$url = 'https://overpass-api.de/api/interpreter?data=' . urlencode($query);
$response = file_get_contents($url, false, $context);
$data = json_decode($response, true);
echo "Total tourism/historic found: " . count($data['elements']) . "\n";
foreach(array_slice($data['elements'], 0, 5) as $el) {
    echo "- " . ($el['tags']['name'] ?? 'Unnamed') . " (" . json_encode($el['tags']) . ")\n";
}
