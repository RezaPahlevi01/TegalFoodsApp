<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: text/plain');

try {
    require __DIR__ . '/../vendor/autoload.php';

    echo "1. Autoload OK\n";

    $app = require __DIR__ . '/../bootstrap/app.php';

    echo "2. Bootstrap OK\n";

    echo '3. ViewServiceProvider: ';
    echo class_exists(\Illuminate\View\ViewServiceProvider::class)
        ? "EXISTS\n"
        : "MISSING\n";

    echo '4. View binding: ';

    try {
        echo $app->make('view') ? "EXISTS\n" : "MISSING\n";
    } catch (\Throwable $e) {
        echo "FAILED\n";
        echo $e->getMessage() . "\n";
    }

    echo "5. Finished\n";

} catch (\Throwable $e) {
    http_response_code(500);

    echo "\nERROR:\n";
    echo $e->getMessage() . "\n\n";
    echo $e->getFile() . ':' . $e->getLine() . "\n\n";
    echo $e->getTraceAsString();
}