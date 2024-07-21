<?php

use App\Http\Livewire\Dash;

use App\Http\Livewire\PosController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\PermisosController;
use App\Http\Controllers\ExportController;
use App\Http\Livewire\Clientes\ClientesController;
use App\Http\Livewire\Videos\VideosController;
use App\Http\Livewire\GruposMusculares\GruposMuscularesController;
use App\Http\Livewire\Equipo\EquipoController;
use App\Http\Livewire\Tags\TagsController;
use App\Http\Livewire\Rutinas\RutinasController;

Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();

Auth::routes(['register' => false]); // deshabilitamos el registro de nuevos users

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', Dash::class);


Route::middleware(['auth'])->group(function () {


    Route::get('clientes', ClientesController::class);
    Route::get('videos', VideosController::class);
    Route::get('gruposM', GruposMuscularesController::class);
    Route::get('tags', TagsController::class);
    Route::get('rutinas', RutinasController::class);
    Route::get('equipo', EquipoController::class);
    Route::group(['middleware' => ['role:Admin']], function () {
        Route::get('roles', RolesController::class);
        Route::get('permisos', PermisosController::class);
    });

    Route::get('users', UsersController::class);


    //reportes PDF
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);


    //reportes EXCEL
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reporteExcel']);
    Route::get('report/excel/{user}/{type}', [ExportController::class, 'reporteExcel']);
});
