<?php
$html = file_get_contents('scratch/error4.html');
if (strpos($html, 'QueryException') !== false) {
    echo "Found: QueryException\n";
}
if (strpos($html, 'SQLSTATE') !== false) {
    echo "Found: SQLSTATE\n";
    $pos = strpos($html, 'SQLSTATE');
    echo "Snippet:\n" . substr($html, max(0, $pos - 100), 500) . "\n";
} else {
    echo "No SQLSTATE found!\n";
}
preg_match('/<title>(.*?)<\/title>/si', $html, $matches);
if (isset($matches[1])) {
    echo "Title: " . trim($matches[1]) . "\n";
}
