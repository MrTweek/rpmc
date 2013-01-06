<?php

$f = file('http://tagesschau.de');

foreach ($f as $l) {
    $l = trim($l);
    if (preg_match('!letzte Sendung!', $l)) {
        $href  = trim(preg_replace('!^.+?href="([^"]+)".+$!', '$1', $l));
        $title = trim(preg_replace('!^.+?title="([^"]+)".+$!', '$1', $l));
    }
}

$f = file($href);
foreach ($f as $l) {
    $l = trim($l);
    if (preg_match('!webL!', $l)) {
        $url = preg_replace('!^.+?href="([^"]+)".+$!', '$1', $l);
    }
}

file_put_contents('/tmp/tagesschau', "$title\n$url");

?>
