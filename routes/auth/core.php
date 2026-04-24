<?php

    Route::get('inicio', 'HomeController@inicio');
    Route::get('logout', 'HomeController@logOut');
    Route::post('actualizar', 'HomeController@actualizarAcceso');

    // PRINCIPAL
    Route::post('/estadistics/chart/line/financiera', 'StatsController@lineFinanciera');
    Route::post('/estadistics/chart/line/ranking', 'StatsController@ranking');
    Route::get('/principal/finance-diario/', 'PrincipalController@financeDiario');
    Route::get('/export/finance-diario', 'PrincipalController@exportFinanceDiario')->name('finance.export');
    Route::post('/principal/table_financiera/', 'PrincipalController@table_financiera');
    Route::post('/principal/table_mes_financiera/', 'PrincipalController@table_mes_financiera');


    //PERFIL
    Route::get('perfil', 'HomeController@perfil');
    Route::post('perfil/{id}', 'HomeController@perfilUpdate');
    Route::get('password', 'HomeController@password');
    Route::post('password/{id}', 'HomeController@passwordUpdate');

    //USUARIO
    Route::get('usuario', ['uses' => 'UsuarioController@index', 'middleware' => ['permission:user-list']]);
    Route::get('usuario/create', ['uses' => 'UsuarioController@create', 'middleware' => ['permission:user-create']]);
    Route::post('usuario/store', ['uses' => 'UsuarioController@store', 'middleware' => ['permission:user-store']]);
    Route::post('usuario/store_actividad', ['uses' => 'UsuarioController@store_actividad', 'middleware' => ['permission:user-store']]);
    Route::get('usuario/show', ['uses' => 'UsuarioController@show', 'middleware' => ['permission:user-show']]);
    Route::get('usuario/edit/{id}', ['uses' => 'UsuarioController@edit', 'middleware' => ['permission:user-edit']]);
    Route::post('usuario/update/{id}', ['uses' => 'UsuarioController@update', 'middleware' => ['permission:user-update']]);
    Route::get('usuario/destroy/{id}', ['uses' => 'UsuarioController@destroy', 'middleware' => ['permission:user-delete']]);
    Route::get('usuario/combo/{id}', ['uses' => 'UsuarioController@combo']);
    //>>>>Filter
    Route::post('/user-filter-data', ['uses' =>  'UsuarioController@filterData']);
    Route::get('usuario/clasificacion_filtro/{id}', ['uses' => 'UsuarioController@clasificacion_filtro']);
