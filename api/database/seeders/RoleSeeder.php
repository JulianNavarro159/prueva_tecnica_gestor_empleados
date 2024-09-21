<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Administrador'],
            ['name' => 'Empleado'],
            ['name' => 'Gerente'],
            ['name' => 'Supervisor'],
            ['name' => 'Analista'],
            ['name' => 'Técnico'],
            ['name' => 'Consultor'],
            ['name' => 'Asistente'],
            ['name' => 'Director'],
            ['name' => 'Coordinador'],
        ];

        DB::table('roles')->insert($roles);
    }
}
