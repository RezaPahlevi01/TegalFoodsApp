<?php

header('Content-Type: text/plain');

try {
    require __DIR__ . '/../vendor/autoload.php';

    echo "AUTOLOAD OK\n";

    $app = require __DIR__ . '/../bootstrap/app.php';

    echo "BOOTSTRAP OK\n";

    echo "BASE PATH: " . $app->basePath() . "\n";

    echo "PROVIDERS:\n";

    foreach ($app->getLoadedProviders() as $provider => $loaded) {
        if ($loaded) {
            echo $provider . "\n";
        }
    }

    echo "\nVIEW PROVIDER: ";

    echo isset($app->getLoadedProviders()[\Illuminate\View\ViewServiceProvider::class])
        ? "LOADED\n"
        : "NOT LOADED\n";

    echo "\nVIEW BINDING: ";

    try {
        $view = $app->make('view');

        echo "OK\n";
        echo get_class($view);

    } catch (\Throwable $e) {
        echo "FAILED\n";
        echo $e->getMessage();
    }

} catch (\Throwable $e) {
    http_response_code(500);

    echo "ERROR\n";
    echo $e->getMessage();
    echo "\n\n";
    echo $e->getFile() . ':' . $e->getLine();
}