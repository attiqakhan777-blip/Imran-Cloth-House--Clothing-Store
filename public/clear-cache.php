<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

try {
    Cache::flush();
    echo "Cache::flush OK<br>";

    DB::table('cache')->delete();
    echo "cache table cleared<br>";

    $kernel->call('cache:clear');
    $kernel->call('config:clear');
    $kernel->call('view:clear');
    $kernel->call('route:clear');
    echo "artisan clears OK<br>";

    echo "<b>Done. Ab is file ko DELETE kar do.</b>";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}
