<?php
$url = 'https://ecofarm-vn.onrender.com/';
$options = [
    'http' => [
        'ignore_errors' => true
    ]
];
$context = stream_context_create($options);
$html = file_get_contents($url, false, $context);
file_put_contents('scratch/error4.html', $html);
echo "Length: " . strlen($html) . "\n";
