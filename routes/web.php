<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\CrocodileManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnclosureManagementController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\LoginLogController;
use App\Http\Controllers\OrganizationsController;
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

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

// Users

Route::get('users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

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

// Organizations

Route::get('organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

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

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');

Route::get('login-logs', [LoginLogController::class, 'index'])
    ->name('login-logs')
    ->middleware('auth');

// Crocodiles

// 鳄鱼信息管理首页
Route::get('crocodile-management', [CrocodileManagementController::class, 'index'])
    ->name('crocodile-management')
    ->middleware('auth');

// 鳄鱼基本信息列表
Route::get('crocodile-management/basic-info', [CrocodileManagementController::class, 'crocodileIndex'])
    ->name('crocodile-management.basic-info')
    ->middleware('auth');

// 创建鳄鱼信息页面
Route::get('crocodile-management/basic-info/create', [CrocodileManagementController::class, 'crocodileCreate'])
    ->name('crocodile-management.basic-info.create')
    ->middleware('auth');

// 保存鳄鱼信息
Route::post('crocodile-management/basic-info', [CrocodileManagementController::class, 'crocodileStore'])
    ->name('crocodile-management.basic-info.store')
    ->middleware('auth');

// 编辑鳄鱼信息页面
Route::get('crocodile-management/basic-info/{crocodile}/edit', [CrocodileManagementController::class, 'crocodileEdit'])
    ->name('crocodile-management.basic-info.edit')
    ->middleware('auth');

// 更新鳄鱼信息
Route::put('crocodile-management/basic-info/{crocodile}', [CrocodileManagementController::class, 'crocodileUpdate'])
    ->name('crocodile-management.basic-info.update')
    ->middleware('auth');

// 删除鳄鱼信息
Route::delete('crocodile-management/basic-info/{crocodile}', [CrocodileManagementController::class, 'crocodileDelete'])
    ->name('crocodile-management.basic-info.delete')
    ->middleware('auth');

// 圈舍管理
Route::get('crocodile-management/enclosure', [EnclosureManagementController::class, 'index'])
    ->name('crocodile-management.enclosure')
    ->middleware('auth');

Route::post('crocodile-management/enclosure/allocate', [EnclosureManagementController::class, 'allocate'])
    ->name('crocodile-management.enclosure.allocate')
    ->middleware('auth');

Route::post('crocodile-management/enclosure/auto-allocate', [EnclosureManagementController::class, 'autoAllocate'])
    ->name('crocodile-management.enclosure.auto-allocate')
    ->middleware('auth');

Route::post('crocodile-management/enclosure/update-status/{crocodileId}', [EnclosureManagementController::class, 'updateStatusOnIsolation'])
    ->name('crocodile-management.enclosure.update-status')
    ->middleware('auth');

Route::put('crocodile-management/enclosure/{enclosure}', [EnclosureManagementController::class, 'update'])
    ->name('crocodile-management.enclosure.update')
    ->middleware('auth');

Route::delete('crocodile-management/enclosure/{enclosure}', [EnclosureManagementController::class, 'destroy'])
    ->name('crocodile-management.enclosure.destroy')
    ->middleware('auth');