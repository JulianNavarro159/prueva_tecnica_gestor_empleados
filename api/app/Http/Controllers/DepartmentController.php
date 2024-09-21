<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        // Obtiene todos los departamentos
        $departments = Department::all();

        // Devuelve los departamentos en formato JSON
        return response()->json($departments);
    }
}
