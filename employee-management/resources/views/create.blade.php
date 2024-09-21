@extends('layout.template')

@section('tituloPagina', 'Agregar Empleado')

@section('contenido')

<div class="card">
    <h5 class="card-header">Agregar nuevo empleado</h5>
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del empleado" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Puesto</label>
                <input type="text" class="form-control" id="position" name="position" placeholder="Puesto del empleado" required>
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salario</label>
                <input type="number" class="form-control" id="salary" name="salary" step="0.01" placeholder="Salario del empleado" required>
            </div>

            <div class="mb-3">
                <label for="hire_date" class="form-label">Fecha de Contratación</label>
                <input type="date" class="form-control" id="hire_date" name="hire_date" required>
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Departamento</label>
                <select class="form-select" id="department_id" name="department_id" required>
                    <option selected disabled>Seleccione un departamento</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department['id'] }}">{{ $department['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="role_id" class="form-label">Rol</label>
                <select class="form-select" id="role_id" name="role_id" required>
                    <option selected disabled>Seleccione un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('employees.index') }}" class="btn btn-info">
                <span class="fa-solid fa-rotate-left"></span> Regresar
            </a>
            <button type="submit" class="btn btn-primary">
                <span class="fa-solid fa-floppy-disk"></span> Guardar
            </button>
        </form>
    </div>
</div>

@endsection
