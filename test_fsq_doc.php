<?php
$html = file_get_contents('https://docs.foursquare.com/fsq-developers-places/reference/migration-guide');
$text = strip_tags($html);
echo substr($text, 0, 3000);
