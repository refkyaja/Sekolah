<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$siswa = App\Models\Siswa::first();
if($siswa) {
    $siswa->username = 'siswa01';
    $siswa->password = bcrypt('password123');
    $siswa->save();
    echo "Test user setup: username -> {$siswa->username}, password -> password123\n";
} else {
    echo "No siswa found in database.\n";
}
