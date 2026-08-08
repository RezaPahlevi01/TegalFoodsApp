<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

try {
    // Vercel hanya menyediakan filesystem writable di /tmp
    $storagePath = '/tmp/laravel-storage';

    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0777, true);
    }

    foreach ([
        $storagePath . '/app',
        $storagePath . '/framework/cache',
        $storagePath . '/framework/sessions',
        $storagePath . '/framework/views',
        $storagePath . '/logs',
    ] as $directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    require __DIR__ . '/../vendor/autoload.php';

    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $app->useStoragePath($storagePath);

    $request = Illuminate\Http\Request::capture();

    $response = $app->handleRequest($request);

    $response->send();

    $app->terminate($request, $response);

} catch (\Throwable $e) {
    http_response_code(500);

    echo '<h1>Laravel Error</h1>';
    echo '<pre>';
    echo htmlspecialchars($e->getMessage());
    echo "\n\n";
    echo htmlspecialchars($e->getFile());
    echo ':';
    echo $e->getLine();
    echo "\n\n";
    echo htmlspecialchars($e->getTraceAsString());
    echo '</pre>';
}