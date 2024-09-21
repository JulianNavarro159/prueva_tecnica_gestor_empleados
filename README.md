# PRUEVA TÉCNICA GESTOR DE EMPLEADOS

## Descripción
Breve descripción del proyecto y su propósito.

## Tabla de Contenidos
1. [Descripción General](#descripción-general)
2. [Requisitos](#requisitos)
3. [Instalación](#instalación)
4. [Uso](#uso)
5. [Estructura del Proyecto](#estructura-del-proyecto)
6. [Endpoints de la API](#endpoints-de-la-api)
7. [Base de Datos](#base-de-datos)
8. [Contribuciones](#contribuciones)

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

2. Instala las dependencias con Composer:
   ```bash
   composer install

3. Configura el archivo '.env' con tus credenciales de base de datos.

4. Ejecuta las migraciones y los seeders:
   ```bash
   php artisan migrate --seed

## Uso

Una vez instalada la aplicación, puedes probar los endpoints con herramientas como Postman o Insomnia.

Para iniciar el servidor de desarrollo, ejecuta:
   ```bash
   php artisan serve --port=8001

La API estará disponible en http://127.0.0.1:8001.

## Estructura del Proyecto

app/Http/Controllers: Controladores de la API.
app/Models: Modelos de las entidades.
database/migrations: Migraciones para la creación de tablas.
database/seeders: Datos de ejemplo para llenar la base de datos.
routes/api.php: Definición de las rutas de la API.
Endpoints de la API
Método	Endpoint	Descripción
POST	/api/employees	Crear un nuevo empleado
GET	/api/employees	Listar empleados con paginación y filtros
GET	/api/employees/{id}	Obtener información de un empleado específico
PUT	/api/employees/{id}	Actualizar un empleado
DELETE	/api/employees/{id}	Eliminar un empleado
Ejemplo de Petición POST para Crear un Empleado
bash
Copiar código
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
Base de Datos
La base de datos cuenta con tres tablas principales:

employees: Almacena la información básica de los empleados.
departments: Almacena los departamentos a los que pertenecen los empleados.
roles: Define los roles de los empleados (Administrador, Empleado, etc.).