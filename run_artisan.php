<?php
// run_artisan.php

// Define os comandos Artisan que você deseja rodar
$commands = [
    'config:cache',
    'route:cache',
    'view:cache',
    'cache:clear',
];

foreach ($commands as $command) {
    echo "<p>Running artisan $command...</p>";
    \Illuminate\Support\Facades\Artisan::call($command);
    echo "<pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
}

echo "Comandos Artisan executados com sucesso!";