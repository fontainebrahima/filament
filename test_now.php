<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Simulate the imports in TestStatWidget
use function Illuminate\Support\now as SupportNow;
// Simulate the imports in TestStatWidget
// use function Symfony\Component\Clock\now;


try {
    echo "Class of now(): " . get_class(now()) . "\n";
    echo "Attempting to access ->year on now():\n";
    echo now()->year;
} catch (\Throwable $e) {   
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "TYPE: " . get_class($e) . "\n";
}
