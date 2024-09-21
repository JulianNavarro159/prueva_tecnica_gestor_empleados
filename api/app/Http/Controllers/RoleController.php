<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        // Obtiene todos los roles
        $roles = Role::all();

        // Devuelve los roles en formato JSON
        return response()->json($roles);
    }
}
