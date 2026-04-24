<?php

    Route::group(['prefix' => '/piptotalpriori/ejecucion', 'middleware' => ['permission:pi-ejecucion-listar']], function () {
        Route::group(['prefix' => '/obra'], function () {
            Route::group(['prefix' => '/evidencia'], function () {
                Route::get('/', ['uses' => 'ObrasController@evidenciaIndex']);
                Route::post('/filter', ['uses' => 'ObrasController@evidenciaFilterData']);
                Route::post('/create', ['uses' => 'ObrasController@evidenciaCreate']);
                Route::post('/store', ['uses' => 'ObrasController@evidenciaStore']);
                Route::post('/delete', ['uses' => 'ObrasController@evidenciaDelete']);
                Route::post('/show', ['uses' => 'ObrasController@evidenciaShowObra']);
                Route::post('/list', ['uses' => 'ObrasController@evidenciaList']);
                Route::post('/list/filter', ['uses' => 'ObrasController@evidenciaListFilter']);

                Route::group(['prefix' => '/img'], function () {
                    Route::get('/get/{idobra}/{fecha}', ['uses' => 'ObrasController@evidenciaImageGet']);
                    Route::post('/upload', ['uses' => 'ObrasController@evidenciaImageStore']);
                    Route::post('/delete', ['uses' => 'ObrasController@evidenciaImageDelete']);
                });
            });

            Route::post('/filter', ['uses' =>  'ObrasController@filterData']);

            Route::post('/filter/ejecucion', ['uses' =>  'ObrasController@filterDataEjecucion']);

            Route::post('/create', ['uses' =>  'ObrasController@create']);
            Route::post('/store', ['uses' =>  'ObrasController@store']);
            Route::post('/edit', ['uses' =>  'ObrasController@edit']);
            Route::post('/show', ['uses' =>  'ObrasController@show']);
            Route::post('/update', ['uses' =>  'ObrasController@update']);

            Route::post('/delete', ['uses' =>  'ObrasController@delete']);

            Route::group(['prefix' => '/inspector'], function () {
                Route::post('/asignar', ['uses' =>  'ObrasController@asignarResponsable']);
                Route::post('/vincular', ['uses' =>  'ObrasController@vincularInspector']);
                Route::post('/desvincular', ['uses' =>  'ObrasController@desvincularInspector']);
            });
        });

        Route::group(['prefix' => '/estado'], function () {
            Route::get('/', ['uses' =>  'ObrasEstadoController@index']);

            Route::post('/filter', ['uses' =>  'ObrasEstadoController@filterData']);

            Route::post('/add', ['uses' =>  'ObrasEstadoController@add']);

            Route::post('/create', ['uses' =>  'ObrasEstadoController@create']);

            Route::post('/delete', ['uses' =>  'ObrasEstadoController@delete']);

            Route::post('/edit', ['uses' =>  'ObrasEstadoController@edit']);
            Route::post('/update', ['uses' =>  'ObrasEstadoController@update']);

            Route::post('/list', ['uses' =>  'ObrasEstadoController@listEstados']);

            Route::post('/img/upload', ['uses' =>  'ObrasEstadoController@imgUpload']);
            Route::get('/img/get/{id}', ['uses' =>  'ObrasEstadoController@imgGet']);
            Route::post('/img/delete', ['uses' =>  'ObrasEstadoController@imgDelete']);
        });
    });

