<?php

    //EXPORT
    Route::get('/exportar', ['as' => 'rptExportar', 'uses' => 'ExportController@index']);
    Route::get('/exportar/{tipo}', ['uses' => 'ExportController@exportar']);
    Route::get('/exportar_proyecto', ['uses' => 'ExportController@exportar_proyecto']);
    Route::get('/exportar_pmi', ['uses' => 'ExportController@exportar_pmi']);
    Route::get('/exportar_proyecto_ff', ['uses' => 'ExportController@exportar_proyecto_ff']);
    Route::get('/reporte_diario', ['uses' => 'ExportController@reporte_prueba']);
    Route::get('/reporte_diario_f12', ['uses' => 'ExportController@reporte_diario_f12']);

    Route::get('/reporte_prueba', ['uses' => 'ExportController@reporte_grafico']);
    Route::get('/reporte_fin_mes', ['uses' => 'ExportController@reporte_diario_fin_mes']);

    Route::post('principal/chart', ['uses' => 'PrincipalController@index'/*,'middleware' => ['permission:report-index']*/]);
    Route::post('principal/dashSearch', ['uses' => 'PrincipalController@dashSearch'/*,'middleware' => ['permission:report-index']*/]);


    Route::get('images', ['uses' => 'ImageController@getServerImagesPage', 'middleware' => ['permission:image-upload']]);
    Route::get('server-images/{uid}', ['as' => 'server-images', 'uses' => 'ImageController@getServerImages', 'middleware' => ['permission:image-list']]);
    //PDF
    Route::any('fileUpload', ['as' => 'upload-pdf', 'uses' => 'PdfController@postUpload', 'middleware' => ['permission:pdf-upload']]);
    Route::get('server-pdf/{uid}', ['as' => 'server-pdf', 'uses' => 'PdfController@getServerPdf', 'middleware' => ['permission:pdf-list']]);
    Route::any('delete-pdf', ['as' => 'delete-pdf', 'uses' => 'PdfController@deletePdf']);

    //AUDIT
    Route::post('audit/piptotalpriori/getAuditChanges', ['uses' =>  'PipTotalPrioriController@getAuditChanges', 'middleware' => ['permission:pi-show']]);

    //INFORMACION FINANCIERA
    /*
         * TODO
         */
    Route::post('infFinanciera/vwEjecucion', ['as' => 'vwEjecucion', 'uses' => 'InfFinancieraController@loadPartial']);
    Route::post('infFinanciera/getEjecucion', ['as' => 'getEjecucion', 'uses' => 'InfFinancieraController@getResumen']);
   
    //ROLES
    // Listar roles
    Route::get('roles', ['uses' => 'RoleController@index','middleware' => ['permission:role-list']])->name('roles.index');
    // Formulario crear
    Route::get('roles/create', ['uses' => 'RoleController@create','middleware' => ['permission:role-create']])->name('roles.create');
    // Guardar nuevo rol
    Route::post('roles', ['uses' => 'RoleController@store','middleware' => ['permission:role-create']])->name('roles.store');
    // Ver rol
    Route::get('roles/{id}', ['uses' => 'RoleController@show','middleware' => ['permission:role-list']])->name('roles.show');
    // Formulario editar
    Route::get('roles/{id}/edit', ['uses' => 'RoleController@edit','middleware' => ['permission:role-edit']])->name('roles.edit');
    // Actualizar rol
    Route::patch('roles/{id}', ['uses' => 'RoleController@update','middleware' => ['permission:role-edit']])->name('roles.update');
    // Eliminar rol
    Route::delete('roles/{id}', ['uses' => 'RoleController@destroy','middleware' => ['permission:role-delete']])->name('roles.destroy');

    Route::post('/getInspectorbyNomOrDNI', ['uses' =>  'UsuarioController@getInspectorbyNomOrDNI']);


    //ACTIVIDAD
    Route::post('ActividadOperativa/ActividadOperativaxActividad', ['uses' => 'ActividadOperativaController@listActividadOperativaxActividad']);

    Route::get('getActividadByUsuario/{idusuario?}', ['uses' => 'ActividadController@getActividadByUsuario'])->where(['idusuario' => '[0-9]+']);

    //DISTRITO
    Route::get('/listDistritoByName', ['uses' => 'UbigeoController@listDistritoByName']);

