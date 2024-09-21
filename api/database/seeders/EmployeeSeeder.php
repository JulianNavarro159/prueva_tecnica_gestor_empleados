<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [];
        for ($i = 1; $i <= 10; $i++) {
            $employees[] = [
                'name' => 'Empleado ' . $i,
                'email' => 'empleado' . $i . '@ejemplo.com',
                'position' => 'Puesto ' . $i,
                'salary' => rand(30000, 80000),
                'hire_date' => Carbon::now()->subDays(rand(1, 365)),
                'department_id' => rand(1, 10), // Suponiendo que tienes 10 departamentos
                'role_id' => rand(1, 10), // Suponiendo que tienes 10 roles
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('employees')->insert($employees);
    }
}
