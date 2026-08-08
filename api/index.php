<?php

use Illuminate\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$storagePath = '/tmp/laravel-storage';

foreach ([
    $storagePath,
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

$app->useStoragePath($storagePath);

$app->handleRequest(Request::capture());