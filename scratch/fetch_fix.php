<?php
$url = 'https://ecofarm-vn.onrender.com/fix-database-sessions';
$options = [
    'http' => [
        'ignore_errors' => true
    ]
];
$context = stream_context_create($options);
$html = file_get_contents($url, false, $context);
echo "Response: " . trim($html) . "\n";
