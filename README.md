# PRUEVA TÉCNICA GESTOR DE EMPLEADOS

## Descripción
Esta es una pequeña aplicación de gestión de empleados que implementa una API REST
utilizando PHP y LARAVEL con el patrón de diseño MVC.

## Tabla de Contenidos
1. [Descripción General](#descripción-general)
2. [Requisitos](#requisitos)
3. [Instalación](#instalación)
4. [Uso](#uso)
5. [Estructura del Proyecto](#estructura-del-proyecto)
6. [Endpoints de la API](#endpoints-de-la-api)
7. [Base de Datos](#base-de-datos)
8. [Descripción de la Aplicación de Gestión de Empleados](#descripción-de-la-aplicación-de-gestión-de-empleados)
9. [Uso de la Aplicación](#uso-de-la-aplicación)
10. [Estructura de la Aplicación](#estructura-de-la-aplicación)

## Descripción General
Este proyecto es una API RESTful desarrollada en Laravel que permite la gestión de empleados, departamentos y roles. Incluye endpoints para crear, listar (con paginación), actualizar y eliminar empleados, junto con la capacidad de filtrar por nombre o departamento.

## Requisitos
- PHP 8.0 o superior
- Composer para la gestión de dependencias
- MySQL o cualquier base de datos compatible con Laravel
- Servidor web (e.g., Apache o Nginx)

## Instalación
1. Clona el repositorio:
   ```bash
   git clone https://github.com/usuario/repositorio.git
   cd tu-repositorio
   ```

2. Instala las dependencias con Composer:
   ```bash
   composer install
   ```

3. Configura el archivo `.env` con tus credenciales de base de datos.

4. Ejecuta las migraciones y los seeders:
    
    Para crear las tablas en la base de datos y llenarlas con datos de prueba, ejecuta el siguiente comando:

    ```bash
    php artisan migrate --seed
    ```
   **Nota: Si no deseas poblar la base de datos con datos de prueba, puedes ejecutar solo el siguiente comando para crear las tablas sin insertar datos:**

    ```bash
    php artisan migrate
    ```
   
## Uso

Una vez instalada la aplicación, puedes probar los endpoints con herramientas como Postman o Insomnia.

Para iniciar el servidor de desarrollo, ejecuta:
   ```bash
   php artisan serve --port=8001
   ```

La API estará disponible en `http://127.0.0.1:8001`.

## Estructura del Proyecto

- `app/Http/Controllers`: Controladores de la API.
- `app/Models`: Modelos de las entidades.
- `database/migrations`: Migraciones para la creación de tablas.
- `database/seeders`: Datos de ejemplo para llenar la base de datos.
- `routes/api.php`: Definición de las rutas de la API.

## Endpoints de la API

| Método | Endpoint              | Descripción                                   |
|--------|-----------------------|-----------------------------------------------|
| POST   | `/api/employees`        | Crear un nuevo empleado                       |
| GET    | `/api/employees`        | Listar empleados con paginación y filtros     |
| GET    | `/api/employees/{id}`   | Obtener información de un empleado específico |
| PUT    | `/api/employees/{id}`   | Actualizar un empleado                        |
| DELETE | `/api/employees/{id}`   | Eliminar un empleado                          |


### Ejemplo de Petición POST para Crear un Empleado

   ```bash
   POST /api/employees
   Content-Type: application/json

   {
        "name": "Juan Pérez",
        "email": "juan.perez@ejemplo.com",
        "position": "Desarrollador",
        "salary": 50000,
        "hire_date": "2023-01-15",
        "department_id": 1,
        "role_id": 2
   }
   ```

## Base de Datos

La base de datos cuenta con tres tablas principales:

1. employees: Almacena la información básica de los empleados.
2. departments: Almacena los departamentos a los que pertenecen los empleados.
3. roles: Define los roles de los empleados (Administrador, Empleado, etc.).

## Descripción de la Aplicación de Gestión de Empleados

La aplicación employee-management está diseñada para interactuar con la API, permitiendo a los usuarios gestionar empleados de manera sencilla. Proporciona una interfaz de usuario donde pueden crear, listar, editar y eliminar empleados, así como filtrar por nombre o departamento.

## Uso de la Aplicación

1. Instala las dependencias con Composer:
   ```bash
   composer install
   ```

2. Para iniciar la aplicación de gestión de empleados, ejecuta:
   ```bash
   php artisan serve
   ```
La aplicación estará disponible en `http://127.0.0.1:8000`.

## Estructura de la Aplicación

- `app/Http/Controllers`: Controladores de la aplicación.
- `app/Models`: Modelos que representan las entidades de la aplicación.
- `resources/views`: Vistas de la aplicación.
- `routes/web.php`: Rutas de la aplicación.