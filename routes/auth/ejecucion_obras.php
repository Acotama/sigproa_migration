<?php

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => '/piptotalpriori/ejecucion', 'middleware' => ['permission:pi-ejecucion-listar']], function () {
        Route::group(['prefix' => '/obra'], function () {
            Route::group(['prefix' => '/evidencia'], function () {
                Route::get('/', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaIndex']);
                Route::post('/filter', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaFilterData']);
                Route::post('/create', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaCreate']);
                Route::post('/store', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaStore']);
                Route::post('/delete', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaDelete']);
                Route::post('/show', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaShowObra']);
                Route::post('/list', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaList']);
                Route::post('/list/filter', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaListFilter']);

                Route::group(['prefix' => '/img'], function () {
                    Route::get('/get/{idobra}/{fecha}', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaImageGet']);
                    Route::post('/upload', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaImageStore']);
                    Route::post('/delete', [\sayhuite\Http\Controllers\ObrasController::class, 'evidenciaImageDelete']);
                });
            });

            Route::post('/filter', [\sayhuite\Http\Controllers\ObrasController::class, 'filterData']);

            Route::post('/filter/ejecucion', [\sayhuite\Http\Controllers\ObrasController::class, 'filterDataEjecucion']);

            Route::post('/create', [\sayhuite\Http\Controllers\ObrasController::class, 'create']);
            Route::post('/store', [\sayhuite\Http\Controllers\ObrasController::class, 'store']);
            Route::post('/edit', [\sayhuite\Http\Controllers\ObrasController::class, 'edit']);
            Route::post('/show', [\sayhuite\Http\Controllers\ObrasController::class, 'show']);
            Route::post('/update', [\sayhuite\Http\Controllers\ObrasController::class, 'update']);

            Route::post('/delete', [\sayhuite\Http\Controllers\ObrasController::class, 'delete']);

            Route::group(['prefix' => '/inspector'], function () {
                Route::post('/asignar', [\sayhuite\Http\Controllers\ObrasController::class, 'asignarResponsable']);
                Route::post('/vincular', [\sayhuite\Http\Controllers\ObrasController::class, 'vincularInspector']);
                Route::post('/desvincular', [\sayhuite\Http\Controllers\ObrasController::class, 'desvincularInspector']);
            });
        });

        Route::group(['prefix' => '/estado'], function () {
            Route::get('/', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'index']);

            Route::post('/filter', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'filterData']);

            Route::post('/add', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'add']);

            Route::post('/create', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'create']);

            Route::post('/delete', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'delete']);

            Route::post('/edit', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'edit']);
            Route::post('/update', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'update']);

            Route::post('/list', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'listEstados']);

            Route::post('/img/upload', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'imgUpload']);
            Route::get('/img/get/{id}', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'imgGet']);
            Route::post('/img/delete', [\sayhuite\Http\Controllers\ObrasEstadoController::class, 'imgDelete']);
        });
    });

