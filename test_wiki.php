<?php
$url = 'https://id.wikipedia.org/w/api.php?action=query&list=geosearch&gscoord=-6.2615|106.8106&gsradius=10000&gslimit=50&format=json';
$response = file_get_contents($url);
$data = json_decode($response, true);
echo "Total Wiki places found: " . count($data['query']['geosearch']) . "\n";
foreach($data['query']['geosearch'] as $place) {
    echo "- " . $place['title'] . "\n";
}
