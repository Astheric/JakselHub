<?php
$html = file_get_contents('https://docs.foursquare.com/fsq-developers-places/reference/migration-guide');
preg_match_all('/<p>(.*?)<\/p>/s', $html, $matches);
foreach (array_slice($matches[1], 0, 10) as $p) {
    echo strip_tags($p) . "\n\n";
}
