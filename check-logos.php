<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verificación de logos de escuelas ===\n\n";

$schools = App\Models\SportsSchool::all();

foreach ($schools as $school) {
    echo "Escuela: {$school->name}\n";
    echo "  Logo en BD: " . ($school->logo ?? 'NULL') . "\n";
    
    if ($school->logo) {
        $fullPath = storage_path('app/public/' . $school->logo);
        echo "  Ruta completa: {$fullPath}\n";
        echo "  Archivo existe: " . (file_exists($fullPath) ? 'SÍ' : 'NO') . "\n";
        
        $publicPath = public_path('storage/' . $school->logo);
        echo "  Ruta pública: {$publicPath}\n";
        echo "  Accesible públicamente: " . (file_exists($publicPath) ? 'SÍ' : 'NO') . "\n";
        
        echo "  URL: " . \Storage::url($school->logo) . "\n";
    }
    echo "\n";
}
