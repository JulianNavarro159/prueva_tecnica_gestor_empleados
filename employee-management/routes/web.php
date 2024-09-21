<?php

use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/', [ViewController::class, 'index'])->name('employees.index');
Route::get('/create', [ViewController::class, 'create'])->name('employees.create');
Route::post('/employees', [ViewController::class, 'store'])->name('employees.store');
Route::get('/edit/{id}', [ViewController::class, 'edit'])->name('employees.edit');
Route::put('/employees/{id}', [ViewController::class, 'update'])->name('employees.update');
Route::get('/detail/{id}', [ViewController::class, 'show'])->name('employees.show');
Route::delete('/delete/{id}', [ViewController::class, 'destroy'])->name('employees.destroy');
