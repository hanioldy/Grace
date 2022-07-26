<?php

use Hani221b\Grace\Controllers\DashboardController;
use Hani221b\Grace\Controllers\StubsControllers\CreateController;
use Hani221b\Grace\Controllers\StubsControllers\CreateFullResource;
use Hani221b\Grace\Controllers\StubsControllers\CreateMigration;
use Hani221b\Grace\Controllers\StubsControllers\CreateModel;
use Hani221b\Grace\Controllers\StubsControllers\CreateRequest;
use Hani221b\Grace\Controllers\StubsControllers\CreateResource;
use Illuminate\Support\Facades\Route;

Route::get('grace_cp', [DashboardController::class, 'grace_cp']);
Route::get('dashboard', [DashboardController::class, 'get_dashboard']);

Route::post('create_model', [CreateModel::class, 'makeModelAlive'])->name('makeModelAlive');
Route::post('create_controller', [CreateController::class, 'makeControllerAlive'])->name('makeControllerAlive');
Route::post('create_migration', [CreateMigration::class, 'makeMigrationAlive'])->name('makeMigrationAlive');
Route::post('create_request', [CreateRequest::class, 'makeRequestAlive'])->name('makeRequestAlive');
Route::post('create_resource', [CreateResource::class, 'makeResourceAlive'])->name('makeResourceAlive');
Route::post('create_full_resource', [CreateFullResource::class, 'makeFullResourceAlive'])->name('makeFullResourceAlive');

//===========================================================
// Langauges
//===========================================================

Route::get('dashboard/languages', [DashboardController::class, 'get_languages'])->name('grace.languages');
Route::get('dashboard/languages/change_status/{id}', [DashboardController::class, 'change_status_for_language'])->name('grace.languages.change_status');
Route::get('dashboard/languages/set_to_default/{id}', [DashboardController::class, 'set_language_to_default'])->name('grace.languages.set_to_default');

//===========================================================
// tables
//===========================================================

Route::get('grace_tables', [DashboardController::class, 'get_tables'])->name('grace_tables');
Route::get('delete_table/{id}', [DashboardController::class, 'delete_table'])->name('delete_table');
