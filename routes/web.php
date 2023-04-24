<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Guest\GuestHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TypeController;
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

Route::get('/', [ GuestHomeController::class, 'index'])->name('home');

Route::get('/home', [ProjectController::class, 'index'] )->middleware('auth')->name('home');

Route::middleware('auth')
->prefix('admin')
->name('admin.')
->group(function() {

  // ! projects resource
  Route::get('/projects/trash',[ProjectController::class, 'trash'])->name('projects.trash');
  Route::put('/projects/{project}/restore',[ProjectController::class, 'restore'])->name('projects.restore');
  Route::delete('/projects/{project}/force-delete',[ProjectController::class, 'forceDelete'])->name('projects.force-delete');
  Route::resource('projects', ProjectController::class);

  // ! types resource
  Route::resource('types', TypeController::class);
});

Route::middleware('auth')
  ->prefix('profile')
  ->name('profile.')
  ->group(function () {
      Route::get('/', [ProfileController::class, 'edit'])->name('edit');
      Route::patch('/', [ProfileController::class, 'update'])->name('update');
      Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
  });

require __DIR__.'/auth.php';