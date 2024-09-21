@extends('layout.template')

@section('tituloPagina', 'Detalles del Empleado')

@section('contenido')

<div class="card">
    <h5 class="card-header">Detalles del empleado</h5>
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <ul class="list-group">
            <li class="list-group-item"><strong>Nombre:</strong> {{ $employee['name'] }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $employee['email'] }}</li>
            <li class="list-group-item"><strong>Puesto:</strong> {{ $employee['position'] }}</li>
            <li class="list-group-item"><strong>Salario:</strong> {{ $employee['salary'] }}</li>
            <li class="list-group-item"><strong>Fecha de Contratación:</strong> {{ $employee['hire_date'] }}</li>
            <li class="list-group-item"><strong>Departamento:</strong> {{ $employee['department']['name'] ?? 'N/A' }}</li>
            <li class="list-group-item"><strong>Rol:</strong> {{ $employee['role']['name'] ?? 'N/A' }}</li>
        </ul>

        <a href="{{ route('employees.index') }}" class="btn btn-info mt-3">
            <span class="fa-solid fa-rotate-left"></span> Regresar
        </a>
        <a href="{{ route('employees.edit', $employee['id']) }}" class="btn btn-warning mt-3">
            <span class="fa-solid fa-user-pen"></span> Editar
        </a>
    </div>
</div>

@endsection
