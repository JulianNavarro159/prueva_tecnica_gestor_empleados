@extends('layout.template')

@section('tituloPagina', 'Gestión de empleados')

@section('contenido')

<div class="card">
    <h5 class="card-header text-center">Gestión de empleados</h5>
    <div class="card-body">
        <h5 class="card-title">Listado de Empleados</h5>

        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('employees.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Buscar por nombre" value="{{ request('name') }}">
                </div>
                <div class="col-md-4">
                    <select name="department_id" class="form-control">
                        <option value="">Seleccione un departamento</option>
                        @foreach($departments as $department)
                            <option value="{{ $department['id'] }}" {{ request('department_id') == $department['id'] ? 'selected' : '' }}>
                                {{ $department['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <span class="fa-solid fa-filter"></span> Filtrar
                    </button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                        <span class="fa-solid fa-broom"></span> Limpiar
                    </a>
                </div>
            </div>
        </form>

        <hr>
        <p class="card-text">
            <div class="table table-responsive">
            @if(isset($employees) && count($employees) > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Salario Comparativo</th> <!-- Nueva columna -->
                            <th>Detalle</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                            <tr>
                                <td>{{ $employee['name'] }}</td>
                                <td>{{ $employee['department']['name'] ?? 'N/A' }}</td>
                                <td>
                                    @if($employee['salary_comparison'] === 'above')
                                        <span class="text-success">Por encima del promedio</span>
                                    @elseif($employee['salary_comparison'] === 'below')
                                        <span class="text-danger">Por debajo del promedio</span>
                                    @else
                                        <span>No disponible</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('employees.show', $employee['id']) }}">
                                        <button class="btn btn-info btn-sm">
                                            <span class="fa-sharp fa-solid fa-circle-info"></span> ver
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('employees.edit', $employee['id']) }}" method="GET">
                                        <button class="btn btn-warning btn-sm">
                                            <span class="fa-solid fa-user-pen"></span>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            onclick="setEmployeeToDelete({{ $employee['id'] }}, '{{ $employee['name'] }}')">
                                        <span class="fa-solid fa-user-xmark"></span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        @if($pagination['current_page'] > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ route('employees.index', array_merge(request()->query(), ['page' => $pagination['current_page'] - 1])) }}">Anterior</a>
                            </li>
                        @endif
                        @for($i = 1; $i <= $pagination['last_page']; $i++)
                            <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                <a class="page-link" href="{{ route('employees.index', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        @if($pagination['current_page'] < $pagination['last_page'])
                            <li class="page-item">
                                <a class="page-link" href="{{ route('employees.index', array_merge(request()->query(), ['page' => $pagination['current_page'] + 1])) }}">Siguiente</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @else
                <p>No hay empleados disponibles.</p>
            @endif

            
                @if(isset($error))
                    <p class="text-danger">{{ $error }}</p>
                @endif
            </div>
        </p>
        <p>
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <span class="fa-sharp fa-solid fa-user-plus"></span> Agregar empleado
            </a>
        </p>
    </div>
</div>

@include('delete_modal')

<script>
function setEmployeeToDelete(employeeId, employeeName) {
    document.getElementById('employeeName').textContent = employeeName;
    document.getElementById('deleteForm').action = `/delete/${employeeId}`;
}
</script>

@endsection
