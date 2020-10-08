<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ParcsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth

Route::get('login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('remember', 'auth');

Route::get('users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

// Parcs

Route::get('parken', [ParcsController::class, 'index'])
    ->name('parcs')
    ->middleware('remember', 'auth');

Route::get('parken/nieuw', [ParcsController::class, 'create'])
    ->name('parcs.create')
    ->middleware('auth');

Route::post('parken', [ParcsController::class, 'store'])
    ->name('parcs.store')
    ->middleware('auth');

Route::get('parken/{parc}/bewerk', [ParcsController::class, 'edit'])
    ->name('parcs.edit')
    ->middleware('auth');

Route::put('parken/{parc}', [ParcsController::class, 'update'])
    ->name('parcs.update')
    ->middleware('auth');

Route::delete('parken/{parc}', [ParcsController::class, 'destroy'])
    ->name('parcs.destroy')
    ->middleware('auth');

Route::put('parken/{parc}/herstel', [ParcsController::class, 'restore'])
    ->name('parcs.restore')
    ->middleware('auth');

// Organizations

Route::get('leveranciers', [SuppliersController::class, 'index'])
    ->name('suppliers')
    ->middleware('remember', 'auth');

Route::get('leveranciers/create', [SuppliersController::class, 'create'])
    ->name('suppliers.create')
    ->middleware('auth');

Route::post('leveranciers', [SuppliersController::class, 'store'])
    ->name('suppliers.store')
    ->middleware('auth');

Route::get('leveranciers/{supplier}/edit', [SuppliersController::class, 'edit'])
    ->name('suppliers.edit')
    ->middleware('auth');

Route::put('leveranciers/{supplier}', [SuppliersController::class, 'update'])
    ->name('suppliers.update')
    ->middleware('auth');

Route::delete('leveranciers/{supplier}', [SuppliersController::class, 'destroy'])
    ->name('suppliers.destroy')
    ->middleware('auth');

Route::put('leveranciers/{supplier}/restore', [SuppliersController::class, 'restore'])
    ->name('suppliers.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('remember', 'auth');

Route::get('contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Reports

Route::get('reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*');

