<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class AssignRolesToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asignar roles de Spatie Permission a usuarios existentes basándose en el campo role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Asignando roles a usuarios existentes...');
        
        $users = User::all();
        $count = 0;
        
        foreach ($users as $user) {
            if ($user->role && !$user->hasRole($user->role)) {
                try {
                    $user->assignRole($user->role);
                    $this->info("✓ Rol '{$user->role}' asignado a {$user->name} ({$user->email})");
                    $count++;
                } catch (\Exception $e) {
                    $this->error("✗ Error asignando rol a {$user->name}: " . $e->getMessage());
                }
            } else {
                $this->line("- {$user->name} ya tiene el rol '{$user->role}' asignado");
            }
        }
        
        $this->newLine();
        $this->info("Total de roles asignados: {$count}");
        
        return 0;
    }
}
