<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function index(Request $request) 
    {
        try {
            // Realiza una solicitud GET a la API de empleados
            $response = Http::timeout(60)->get('http://127.0.0.1:8001/api/employees', $request->query());

            // Realiza una solicitud GET a la API de departamentos
            $departmentsResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/departments');

            // Verifica si hubo algún fallo en las respuestas
            if ($response->failed() || $departmentsResponse->failed()) {
                \Log::error('Error al obtener empleados o departamentos', [
                    'employees_status' => $response->status(),
                    'departments_status' => $departmentsResponse->status(),
                ]);
                return view('index')->with('error', 'Error al obtener empleados o departamentos.');
            }

            // Extrae los datos de las respuestas
            $employeesData = $response->json();
            $departments = $departmentsResponse->json();

            // Verifica la estructura de las respuestas JSON
            if (!isset($employeesData['data']) || !is_array($employeesData['data'])) {
                \Log::error('Estructura de respuesta inesperada para empleados', ['response' => $employeesData]);
                return view('index')->with('error', 'Error al procesar los datos de empleados.');
            }

            // Extrae los datos de paginación y empleados
            $employees = $employeesData['data'];
            $pagination = [
                'current_page' => $employeesData['current_page'],
                'last_page' => $employeesData['last_page'],
                'per_page' => $employeesData['per_page'],
                'total' => $employeesData['total'],
            ];

            // Pasa los datos a la vista
            return view('index', compact('employees', 'departments', 'pagination'));
        } catch (\Exception $e) {
            \Log::error('Excepción al obtener empleados o departamentos', ['exception' => $e]);
            return view('index')->with('error', 'Error al obtener empleados o departamentos.');
        }
    }


    public function create()
    {
        // Realiza solicitudes GET a las APIs de departamentos y roles
        $departmentsResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/departments');
        $rolesResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/roles');

        // Verifica si hubo algún fallo en las respuestas
        if ($departmentsResponse->failed() || $rolesResponse->failed()) {
            \Log::error('Error al obtener departamentos o roles', [
                'departments_status' => $departmentsResponse->status(),
                'roles_status' => $rolesResponse->status(),
            ]);
            return view('create')->with('error', 'Error al obtener departamentos o roles.');
        }

        // Extrae los datos de las respuestas
        $departments = $departmentsResponse->json();
        $roles = $rolesResponse->json();

        // Pasa los departamentos y roles a la vista
        return view('create', compact('departments', 'roles'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'department_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        // Enviar los datos a la API
        $response = Http::post('http://127.0.0.1:8001/api/employees', $validatedData);

        // Manejo de errores específico para 422 (errores de validación)
        if ($response->status() === 422) {
            return back()->withErrors($response->json()['errors']);
        }

        // Verifica si la respuesta fue exitosa
        if ($response->successful()) {
            return redirect()->route('employees.index')->with('success', 'Empleado agregado exitosamente');
        } else {
            // Registrar el error y mostrar un mensaje genérico
            \Log::error('Error al agregar empleado', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return back()->withErrors(['error' => 'Error al agregar el empleado: ' . $response->json()['message']]);
        }
    }

    public function show($id)
    {
        // Realiza la solicitud GET a la API para obtener los detalles del empleado
        $response = Http::get("http://127.0.0.1:8001/api/employees/{$id}");

        if ($response->failed()) {
            \Log::error('Error al obtener los detalles del empleado', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return redirect()->route('employees.index')->with('error', 'Error al obtener los detalles del empleado');
        }

        // Obtén los detalles del empleado de la respuesta
        $employee = $response->json();

        // Pasa los datos del empleado a la vista
        return view('detail', compact('employee'));
    }


    public function edit($id)
    {
        // Realiza una solicitud GET a la API para obtener los datos del empleado
        $response = Http::timeout(60)->get("http://127.0.0.1:8001/api/employees/{$id}");
    
        if ($response->failed()) {
            \Log::error('Error al obtener el empleado', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return back()->withErrors(['error' => 'Error al obtener los datos del empleado.']);
        }
    
        $employee = $response->json(); // Datos del empleado
    
        // Obtener departamentos y roles para el select
        $departmentsResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/departments');
        $rolesResponse = Http::timeout(60)->get('http://127.0.0.1:8001/api/roles');
    
        if ($departmentsResponse->failed() || $rolesResponse->failed()) {
            \Log::error('Error al obtener departamentos o roles', [
                'departments_status' => $departmentsResponse->status(),
                'roles_status' => $rolesResponse->status(),
            ]);
            return back()->withErrors(['error' => 'Error al obtener departamentos o roles.']);
        }
    
        $departments = $departmentsResponse->json();
        $roles = $rolesResponse->json();
    
        // Pasa los datos del empleado, departamentos y roles a la vista
        return view('update', compact('employee', 'departments', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'hire_date' => 'required|date',
            'department_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        // Realiza la solicitud PUT a la API para actualizar el empleado
        $response = Http::put("http://127.0.0.1:8001/api/employees/{$id}", $validatedData);

        if ($response->successful()) {
            return redirect()->route('employees.index')->with('success', 'Empleado actualizado exitosamente');
        } else {
            return back()->withErrors('Error al actualizar el empleado: ' . $response->body());
        }
    }

    public function destroy($id)
    {
        // Realiza una solicitud DELETE a la API para eliminar al empleado
        $response = Http::delete("http://127.0.0.1:8001/api/employees/{$id}");

        if ($response->successful()) {
            return redirect()->route('employees.index')->with('success', 'Empleado eliminado exitosamente');
        } else {
            return back()->withErrors('Error al eliminar el empleado: ' . $response->body());
        }
    }


}
