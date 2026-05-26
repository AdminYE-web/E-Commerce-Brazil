<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing connection to port 3306 ===\n";
try {
    config(['database.connections.mysql.port' => '3306']);
    DB::purge('mysql');
    DB::reconnect('mysql');
    
    echo "Connected successfully to port 3306!\n";
    echo "Current DB Name: " . DB::connection()->getDatabaseName() . "\n";
    
    echo "\n=== Show Databases (3306) ===\n";
    foreach (DB::select('SHOW DATABASES') as $db) {
        print_r($db);
    }
    
    echo "\n=== Show Tables (3306) ===\n";
    foreach (DB::select('SHOW TABLES') as $table) {
        print_r($table);
    }
} catch (\Exception $e) {
    echo "Error connecting to 3306: " . $e->getMessage() . "\n";
}
