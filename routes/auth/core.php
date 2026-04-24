<?php

use Illuminate\Support\Facades\Route;

    Route::get('inicio', [\sayhuite\Http\Controllers\HomeController::class, 'inicio']);
    Route::get('logout', [\sayhuite\Http\Controllers\HomeController::class, 'logOut']);
    Route::post('actualizar', [\sayhuite\Http\Controllers\HomeController::class, 'actualizarAcceso']);

    // PRINCIPAL
    Route::post('/estadistics/chart/line/financiera', [\sayhuite\Http\Controllers\StatsController::class, 'lineFinanciera']);
    Route::post('/estadistics/chart/line/ranking', [\sayhuite\Http\Controllers\StatsController::class, 'ranking']);
    Route::get('/principal/finance-diario/', [\sayhuite\Http\Controllers\PrincipalController::class, 'financeDiario']);
    Route::get('/export/finance-diario', [\sayhuite\Http\Controllers\PrincipalController::class, 'exportFinanceDiario'])->name('finance.export');
    Route::post('/principal/table_financiera/', [\sayhuite\Http\Controllers\PrincipalController::class, 'table_financiera']);
    Route::post('/principal/table_mes_financiera/', [\sayhuite\Http\Controllers\PrincipalController::class, 'table_mes_financiera']);


    //PERFIL
    Route::get('perfil', [\sayhuite\Http\Controllers\HomeController::class, 'perfil']);
    Route::post('perfil/{id}', [\sayhuite\Http\Controllers\HomeController::class, 'perfilUpdate']);
    Route::get('password', [\sayhuite\Http\Controllers\HomeController::class, 'password']);
    Route::post('password/{id}', [\sayhuite\Http\Controllers\HomeController::class, 'passwordUpdate']);

    //USUARIO
    Route::get('usuario', [\sayhuite\Http\Controllers\UsuarioController::class, 'index'])->middleware(['permission:user-list']);
    Route::get('usuario/create', [\sayhuite\Http\Controllers\UsuarioController::class, 'create'])->middleware(['permission:user-create']);
    Route::post('usuario/store', [\sayhuite\Http\Controllers\UsuarioController::class, 'store'])->middleware(['permission:user-store']);
    Route::post('usuario/store_actividad', [\sayhuite\Http\Controllers\UsuarioController::class, 'store_actividad'])->middleware(['permission:user-store']);
    Route::get('usuario/show', [\sayhuite\Http\Controllers\UsuarioController::class, 'show'])->middleware(['permission:user-show']);
    Route::get('usuario/edit/{id}', [\sayhuite\Http\Controllers\UsuarioController::class, 'edit'])->middleware(['permission:user-edit']);
    Route::post('usuario/update/{id}', [\sayhuite\Http\Controllers\UsuarioController::class, 'update'])->middleware(['permission:user-update']);
    Route::get('usuario/destroy/{id}', [\sayhuite\Http\Controllers\UsuarioController::class, 'destroy'])->middleware(['permission:user-delete']);
    Route::get('usuario/combo/{id}', [\sayhuite\Http\Controllers\UsuarioController::class, 'combo']);
    //>>>>Filter
    Route::post('/user-filter-data', [\sayhuite\Http\Controllers\UsuarioController::class, 'filterData']);
    Route::get('usuario/clasificacion_filtro/{id}', [\sayhuite\Http\Controllers\UsuarioController::class, 'clasificacion_filtro']);
