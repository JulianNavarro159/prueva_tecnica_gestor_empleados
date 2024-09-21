<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Recursos Humanos'],
            ['name' => 'Desarrollo'],
            ['name' => 'Ventas'],
            ['name' => 'Marketing'],
            ['name' => 'Finanzas'],
            ['name' => 'Operaciones'],
            ['name' => 'IT'],
            ['name' => 'Soporte'],
            ['name' => 'Logística'],
            ['name' => 'Calidad'],
        ];

        DB::table('departments')->insert($departments);
    }
}
