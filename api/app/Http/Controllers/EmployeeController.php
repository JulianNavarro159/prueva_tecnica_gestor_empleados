<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el salario promedio por departamento
        $averageSalaries = Employee::select('department_id', \DB::raw('AVG(salary) as avg_salary'))
            ->groupBy('department_id')
            ->pluck('avg_salary', 'department_id');

        // Consulta principal
        $query = Employee::with(['department', 'role'])
            ->select('employees.*') // Selecciona todos los campos de empleados
            ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
            ->leftJoin('roles', 'employees.role_id', '=', 'roles.id');

        // Filtrar por nombre o departamento
        if ($request->has('name')) {
            $query->where('employees.name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('department_id')) {
            $query->where('employees.department_id', $request->department_id);
        }

        // Obtener empleados con paginación
        $employees = $query->paginate(4);

        // Agregar comparación de salario a cada empleado
        $employees->getCollection()->transform(function($employee) use ($averageSalaries) {
            $avgSalary = $averageSalaries[$employee->department_id] ?? null;
            $employee->salary_comparison = $avgSalary !== null 
                ? ($employee->salary > $avgSalary ? 'above' : 'below') 
                : null;
            return $employee;
        });

        // Retornar respuesta paginada
        return response()->json($employees);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $employee = Employee::with(['department', 'role'])->findOrFail($id);
        return response()->json($employee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return response()->json($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        return response()->json(null, 204);
    }
}
