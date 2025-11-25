<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verificación de usuarios ===\n\n";

$master = App\Models\User::where('email', 'master@clubsportal.com')->first();
if ($master) {
    echo "Master:\n";
    echo "  ID: {$master->id}\n";
    echo "  Role: {$master->role}\n";
    echo "  School ID: " . ($master->sports_school_id ?? 'NULL') . "\n";
    echo "  isMaster(): " . ($master->isMaster() ? 'true' : 'false') . "\n";
    echo "  sportsSchool: " . ($master->sportsSchool ? $master->sportsSchool->name : 'NULL') . "\n\n";
}

$admin = App\Models\User::where('email', 'admin@cdmadrid.com')->first();
if ($admin) {
    echo "Admin Madrid:\n";
    echo "  ID: {$admin->id}\n";
    echo "  Role: {$admin->role}\n";
    echo "  School ID: " . ($admin->sports_school_id ?? 'NULL') . "\n";
    echo "  isSchoolAdmin(): " . ($admin->isSchoolAdmin() ? 'true' : 'false') . "\n";
    echo "  sportsSchool: " . ($admin->sportsSchool ? $admin->sportsSchool->name : 'NULL') . "\n\n";
}

$coach = App\Models\User::where('email', 'coach@cdmadrid.com')->first();
if ($coach) {
    echo "Coach Madrid:\n";
    echo "  ID: {$coach->id}\n";
    echo "  Role: {$coach->role}\n";
    echo "  School ID: " . ($coach->sports_school_id ?? 'NULL') . "\n";
    echo "  isCoach(): " . ($coach->isCoach() ? 'true' : 'false') . "\n";
    echo "  sportsSchool: " . ($coach->sportsSchool ? $coach->sportsSchool->name : 'NULL') . "\n\n";
}

echo "=== Verificación de condiciones de menú ===\n\n";

if ($admin) {
    echo "Para admin@cdmadrid.com:\n";
    echo "  auth()->user()->isMaster(): " . ($admin->isMaster() ? 'true' : 'false') . "\n";
    echo "  auth()->user()->sportsSchool: " . ($admin->sportsSchool ? 'EXISTE' : 'NULL') . "\n";
    echo "  auth()->user()->isSchoolAdmin(): " . ($admin->isSchoolAdmin() ? 'true' : 'false') . "\n";
    echo "  auth()->user()->isCoach(): " . ($admin->isCoach() ? 'true' : 'false') . "\n";
}
