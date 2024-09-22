<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    private function handleApiResponse($response, $context)
    {
        if ($response->failed()) {
            \Log::error("Error en $context", [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }
        return $response->json();
    }

    public function index(Request $request)
    {
        try {
            $employeesResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/employees', $request->query());
            $departmentsResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/departments');

            $employeesData = $this->handleApiResponse($employeesResponse, 'obtener empleados');
            $departments = $this->handleApiResponse($departmentsResponse, 'obtener departamentos');

            if (is_null($employeesData) || is_null($departments)) {
                return view('index')->with('error', 'Error al obtener empleados o departamentos.');
            }

            if (!isset($employeesData['data']) || !is_array($employeesData['data'])) {
                \Log::error('Estructura de respuesta inesperada para empleados', ['response' => $employeesData]);
                return view('index')->with('error', 'Error al procesar los datos de empleados.');
            }

            $employees = $employeesData['data'];
            $pagination = [
                'current_page' => $employeesData['current_page'],
                'last_page' => $employeesData['last_page'],
                'per_page' => $employeesData['per_page'],
                'total' => $employeesData['total'],
            ];

            return view('index', compact('employees', 'departments', 'pagination'));
        } catch (\Exception $e) {
            \Log::error('Excepción al obtener empleados o departamentos', ['exception' => $e]);
            return view('index')->with('error', 'Error al obtener empleados o departamentos.');
        }
    }

    public function create()
    {
        $departmentsResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/departments');
        $rolesResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/roles');

        $departments = $this->handleApiResponse($departmentsResponse, 'obtener departamentos');
        $roles = $this->handleApiResponse($rolesResponse, 'obtener roles');

        if (is_null($departments) || is_null($roles)) {
            return view('create')->with('error', 'Error al obtener departamentos o roles.');
        }

        return view('create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'department_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        $response = Http::post('http://127.0.0.1:8001/api/employees', $validatedData);

        if ($response->status() === 422) {
            return back()->withErrors($response->json()['errors']);
        }

        if ($response->successful()) {
            return redirect()->route('employees.index')->with('success', 'Empleado agregado exitosamente');
        } else {
            return back()->withErrors(['error' => 'Error al agregar el empleado: ' . $response->json()['message']]);
        }
    }

    public function show($id)
    {
        $response = Http::get("http://127.0.0.1:8001/api/employees/{$id}");
        $employee = $this->handleApiResponse($response, 'obtener detalles del empleado');

        if (is_null($employee)) {
            return redirect()->route('employees.index')->with('error', 'Error al obtener los detalles del empleado');
        }

        return view('detail', compact('employee'));
    }

    public function edit($id)
    {
        $employeeResponse = Http::timeout(60)->get("http://127.0.0.1:8001/api/employees/{$id}");
        $employee = $this->handleApiResponse($employeeResponse, 'obtener el empleado');

        if (is_null($employee)) {
            return back()->withErrors(['error' => 'Error al obtener los datos del empleado.']);
        }

        $departmentsResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/departments');
        $rolesResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/roles');

        $departments = $this->handleApiResponse($departmentsResponse, 'obtener departamentos');
        $roles = $this->handleApiResponse($rolesResponse, 'obtener roles');

        if (is_null($departments) || is_null($roles)) {
            return back()->withErrors(['error' => 'Error al obtener departamentos o roles.']);
        }

        return view('update', compact('employee', 'departments', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'department_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        $response = Http::put("http://127.0.0.1:8001/api/employees/{$id}", $validatedData);

        if ($response->successful()) {
            return redirect()->route('employees.index')->with('success', 'Empleado actualizado exitosamente');
        } else {
            return back()->withErrors('Error al actualizar el empleado: ' . $response->body());
        }
    }

    public function destroy($id)
    {
        $response = Http::delete("http://127.0.0.1:8001/api/employees/{$id}");

        if ($response->successful()) {
            return redirect()->route('employees.index')->with('success', 'Empleado eliminado exitosamente');
        } else {
            return back()->withErrors('Error al eliminar el empleado: ' . $response->body());
        }
    }
}
