<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $widget = app()->make(\App\Filament\Widgets\TestStatWidget::class);
    $r = new \ReflectionMethod($widget, 'getStats');
    $r->setAccessible(true);
    $stats = $r->invoke($widget);
    print_r($stats);
    echo "SUCCESS\n";
} catch (\Throwable $e) {
    echo $e;
}
