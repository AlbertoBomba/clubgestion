<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$match = App\Models\SeasonMatch::whereNotNull('lineup')->first();

if ($match) {
    echo "Match ID: " . $match->id . "\n";
    echo "Formation: " . $match->formation . "\n";
    echo "Lineup: " . json_encode($match->lineup, JSON_PRETTY_PRINT) . "\n";
} else {
    echo "No matches with lineup found\n";
}
