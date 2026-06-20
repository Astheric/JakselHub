<?php
$query = '[out:json][timeout:25];
area["name"="Jakarta Selatan"]->.searchArea;
(
  node["leisure"="park"]["name"](area.searchArea);
  way["leisure"="park"]["name"](area.searchArea);
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
$withImage = 0;
$withWiki = 0;
foreach($data['elements'] as $el) {
    if (isset($el['tags']['image'])) {
        echo "- " . $el['tags']['name'] . " -> Image: " . $el['tags']['image'] . "\n";
        $withImage++;
    }
    if (isset($el['tags']['wikipedia']) || isset($el['tags']['wikidata'])) {
        $withWiki++;
    }
}
echo "Total with explicit 'image' tag: $withImage\n";
echo "Total with 'wikipedia' or 'wikidata' tag: $withWiki\n";
