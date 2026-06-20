<?php
$query = '[out:json][timeout:25];
area["name"="Jakarta Selatan"]->.searchArea;
(
  node["railway"="station"](area.searchArea);
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
echo "Total stations found: " . count($data['elements']) . "\n";
foreach(array_slice($data['elements'], 0, 15) as $el) {
    echo "- " . ($el['tags']['name'] ?? 'Unnamed') . " (" . ($el['tags']['network'] ?? 'No network') . ")\n";
}
