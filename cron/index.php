<?php
$base = __DIR__;

$run = function (string $file) use ($base): array {
    ob_start();
    include $base . '/' . $file;
    $raw = trim(ob_get_clean());

    $json = json_decode($raw, true);
    return is_array($json)
        ? ['file' => $file, 'result' => $json]
        : ['file' => $file, 'result' => ['ok' => false, 'raw' => $raw]];
};

$results = [
    $run('token.php'),
    $run('queue.php'),
    $run('status.php'),
];

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ok' => true,
    'cron' => 'all',
    'results' => $results,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
