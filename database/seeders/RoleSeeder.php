<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'administrador']);
        $clientRole = Role::create(['name' => 'cliente']);

        // Crear permisos
        Permission::create(['name' => 'crear horarios'])->syncRoles($adminRole);
        Permission::create(['name' => 'aprobar reservas'])->syncRoles($adminRole);
        Permission::create(['name' => 'rechazar reservas'])->syncRoles($adminRole);
        Permission::create(['name' => 'ver horarios'])->syncRoles($adminRole, $clientRole);
        Permission::create(['name' => 'hacer reserva'])->syncRoles($adminRole, $clientRole);
        Permission::create(['name' => 'cancelar reserva'])->syncRoles($adminRole, $clientRole);
    }
}
