<?php

    // PROYECTOS
    Route::group(['prefix' => '/proyecto'], function () {
        Route::get('/inicio', ['uses' => 'ProyectoController@index', 'middleware' => ['permission:pir-proyectoinversionagrupado']]);
        Route::post('/table_financiera', ['uses' => 'ProyectoController@table_financiera', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::get('/table_financiera_exportar', ['uses' => 'ProyectoController@table_financiera_exportar', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/table_mes_financiera', ['uses' => 'ProyectoController@table_mes_financiera', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/lineFinanciera', ['uses' => 'ProyectoController@lineFinanciera', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/show', ['uses' => 'ProyectoController@show', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/showpry', ['uses' => 'ProyectoController@showpry', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::get('/abrirproyecto', ['uses' => 'ProyectoController@abrirproyecto', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/showMeta', ['uses' => 'ProyectoController@showMeta', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/showFuente', ['uses' => 'ProyectoController@showFuente', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/ejecucionmeta', ['uses' => 'ProyectoController@ejecucionmeta', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/showprydev', ['uses' => 'ProyectoController@showprydev', 'middleware' => ['permission:pir-proyectoinversion']]);
        //Seguimiento de Inversiones
        Route::post('/reporte_inversiones', ['uses' => 'ProyectoController@reporte_inversiones', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::get('/historia_anio', ['uses' => 'ProyectoController@historia_anio', 'middleware' => ['permission:pir-proyectoinversion']]);
        //Lista de Proyecto
        Route::get('/lista_proyecto', ['uses' => 'ProyectoController@lista_proyecto', 'middleware' => ['permission:pir-proyectoinversion']]);
        Route::post('/lista_proyecto_data', ['uses' => 'ProyectoController@lista_proyecto_data', 'middleware' => ['permission:pir-proyectoinversion']]);
    });

    Route::group(['prefix' => '/actividad'], function () {
        Route::get('/', ['uses' => 'p_actividadController@inicio', 'middleware' => ['permission:pir-ejecucionfinanciera']]);
        Route::get('/datos', ['uses' => 'p_actividadController@datos', 'middleware' => ['permission:pir-ejecucionfinanciera']]);
    });

    Route::group(['prefix' => '/procedimiento'], function () {
        Route::get('/nuevo2', ['uses' => 'ProcedimientoController@inicio']);
        Route::post('/datos', ['uses' => 'ProcedimientoController@datos']);
        Route::get('/datosjson', ['uses' => 'ProcedimientoController@datosjson']);
        Route::post('/datosproyecto', ['uses' => 'ProcedimientoController@datosproyecto']);
        Route::post('/datosrequerimientos', ['uses' => 'ProcedimientoController@datosrequerimientos']);
        Route::post('/datosrequerimientosfiltro', ['uses' => 'ProcedimientoController@datosrequerimientosfiltro']);
        Route::get('/subir', ['uses' => 'ProcedimientoController@subir']);
        Route::post('/guardar', ['uses' => 'ProcedimientoController@guardar']);
        Route::post('/guardarf', ['uses' => 'ProcedimientoController@guardar_formulario']);
        Route::get('/nuevo', ['uses' => 'ProcedimientoController@nuevo']);
        Route::get('/exportar', ['uses' => 'ProcedimientoController@exportar_excel']);
        Route::get('/resumen', ['uses' => 'ProcedimientoController@resumen']);
    });

    Route::group(['prefix' => '/contratacionesps'], function () {
        Route::get('/', ['uses' => 'ContratacionesController@inicio', 'middleware' => ['permission:pir-contrataciones']]);
        Route::post('/data', ['uses' => 'ContratacionesController@data', 'middleware' => ['permission:pir-contrataciones']]);
        Route::post('/show', ['uses' => 'ContratacionesController@show', 'middleware' => ['permission:pir-contrataciones']]);
        Route::post('/showpry', ['uses' => 'ContratacionesController@showpry', 'middleware' => ['permission:pir-contrataciones']]);
    });


    Route::group(['prefix' => '/carterapmi'], function () {
        Route::get('/', ['uses' => 'CarteraPMIController@inicio', 'middleware' => ['permission:pir-pmi']]);
        Route::get('/datos', ['uses' => 'CarteraPMIController@datos', 'middleware' => ['permission:pir-pmi']]);
    });

    Route::group(['prefix' => '/formato12b'], function () {
        Route::get('/', ['uses' => 'formato12bController@inicio', 'middleware' => ['permission:pir-formato12b']]);
        Route::post('/datos', ['uses' => 'formato12bController@datos', 'middleware' => ['permission:pir-formato12b']]);
        Route::post('/actualizacion', ['uses' => 'formato12bController@actualizacion_f12b', 'middleware' => ['permission:pir-formato12b']]);
        Route::post('/data', ['uses' => 'formato12bController@datos_f12b', 'middleware' => ['permission:pir-formato12b']]);
        Route::get('/reporte', ['uses' => 'formato12bController@reporte', 'middleware' => ['permission:pir-formato12b']]);
        Route::post('/showpry', ['uses' => 'formato12bController@showpry', 'middleware' => ['permission:pir-formato12b']]);
        Route::post('/showpryET', ['uses' => 'formato12bController@showpryET', 'middleware' => ['permission:pir-formato12b']]);
        Route::post('/showpryETDetalle', ['uses' => 'formato12bController@showpryETDetalle', 'middleware' => ['permission:pir-formato12b']]);
        Route::get('/exportar', ['uses' => 'formato12bController@exportar', 'middleware' => ['permission:pir-formato12b']]);
    });

    Route::group(['prefix' => '/gore'], function () {
        Route::get('/goreejecutivo', ['uses' => 'GoreController@goreejecutivo']);
        Route::post('/goreejecutivocargar', ['uses' => 'GoreController@goreejecutivocargar']);
        Route::get('/goreejecutivoagenda', ['uses' => 'GoreController@goreejecutivoagenda']);
        Route::post('/goreejecutivoagendacargar', ['uses' => 'GoreController@goreejecutivoagendacargar']);
        Route::post('/goreejecutivoagendatranferencia', ['uses' => 'GoreController@ver_trans_asig_nacional']);
    });

    Route::group(['prefix' => '/acta'], function () {
        Route::get('/inicio', ['uses' => 'ActaController@inicio', 'middleware' => ['permission:pir-actaseguimiento']]);
        Route::post('/acuerdos', ['uses' => 'ActaController@acuerdos', 'middleware' => ['permission:pir-actaseguimiento']]);
    });

    // Route::group(['prefix' => '/habilitador'], function () {
    //     Route::get('/inicio', ['uses' => 'HabilitadoresController@inicio','middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/anulacion', ['uses' => 'HabilitadoresController@anulacion','middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/credito', ['uses' => 'HabilitadoresController@credito','middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/agregar', ['uses' => 'HabilitadoresController@agregar','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/data', ['uses' => 'HabilitadoresController@data','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/insertardata', ['uses' => 'HabilitadoresController@insertardata','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/eliminardata', ['uses' => 'HabilitadoresController@eliminardata','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::get('/art', ['uses' => 'HabilitadoresController@analisis','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/data_analisis', ['uses' => 'HabilitadoresController@data_analisis','middleware' => ['permission:pir-habilitador-mant']]);
    // });

    // Route::group(['prefix' => '/habilitador'], function () {
    //     Route::get('/inicio', ['uses' => 'HabilitadoresController@inicio','middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/anulacion', ['uses' => 'HabilitadoresController@anulacion','middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/credito', ['uses' => 'HabilitadoresController@credito','middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/agregar', ['uses' => 'HabilitadoresController@agregar','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/data', ['uses' => 'HabilitadoresController@data','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/insertardata', ['uses' => 'HabilitadoresController@insertardata','middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/eliminardata', ['uses' => 'HabilitadoresController@eliminardata','middleware' => ['permission:pir-habilitador-mant']]);
    // });

    Route::group(['prefix' => '/modificacion_presupuestal'], function () {
        Route::get('/generar', ['uses' => 'ModificacionPresupuestalController@modificacion_presupuestal', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::get('/data_analisis', ['uses' => 'ModificacionPresupuestalController@data_analisis', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::get('/exportar', ['uses' => 'ModificacionPresupuestalController@exportar', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::get('/lista', ['uses' => 'ModificacionPresupuestalController@lista', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::get('/data', ['uses' => 'ModificacionPresupuestalController@listadata ', 'middleware' => ['permission:pir-modificacion_presupuestal']]);

        Route::get('/inicio', ['uses' => 'ModificacionPresupuestalController@inicio', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/modal_importar', ['uses' => 'ModificacionPresupuestalController@modal_importar', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/importar', ['uses' => 'ModificacionPresupuestalController@importar', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/consulta_modificacion', ['uses' => 'ModificacionPresupuestalController@consulta_modificacion', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/exportarreporte', ['uses' => 'ModificacionPresupuestalController@exportarreporte', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/buscarproyecto', ['uses' => 'ModificacionPresupuestalController@buscarproyecto', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/guardar', ['uses' => 'ModificacionPresupuestalController@guardar', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/buscardocumento', ['uses' => 'ModificacionPresupuestalController@buscardocumento', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/ver_modificacion', ['uses' => 'ModificacionPresupuestalController@ver_modificacion', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
        Route::post('/eliminar', ['uses' => 'ModificacionPresupuestalController@eliminar', 'middleware' => ['permission:pir-modificacion_presupuestal']]);
    });

    Route::group(['prefix' => '/noprevistas'], function () {
        Route::get('/inicio', ['uses' => 'NoPrevistasController@inicio', 'middleware' => ['permission:pir-noprevistas']]);
        // Route::post('/data', ['uses' => 'NoPrevistasController@noprevistas','middleware' => ['permission:pir-noprevistas']]);
        Route::post('/data', ['uses' => 'NoPrevistasController@data', 'middleware' => ['permission:pir-noprevistas']]);
        Route::post('/agregar', ['uses' => 'NoPrevistasController@agregar', 'middleware' => ['permission:pir-noprevistas-mant']]);
        Route::post('/insertardata', ['uses' => 'NoPrevistasController@insertardata', 'middleware' => ['permission:pir-noprevistas-mant']]);
        Route::post('/eliminardata', ['uses' => 'NoPrevistasController@eliminardata', 'middleware' => ['permission:pir-noprevistas-mant']]);
    });

    Route::group(['prefix' => '/consultamigable'], function () {
        Route::get('/', ['uses' => 'ConsultamigableController@inicio', 'middleware' => ['permission:pir-consultamigable']]);
    });

    /*
    * CHECK SESSION
    */
    Route::get('check-session', 'HomeController@checkSession');

    // Route::get('enviocorreo', function () {
    Route::group(['prefix' => '/enviocorreo'], function () {
        Route::post('/reportediario', ['uses' => 'EnviocorreoController@GuardarImagen']);
        // $correo = new MensajeRecibido;
        // Mail::to('frankazaneroramirez@gmail.com')->send($correo);

        // return "Mensaje Enviado";
    });

    // SIAF
    Route::group(['prefix' => '/siaf'], function () {
        Route::get('/', ['uses' => 'siaf\SiafController@inicio', 'middleware' => ['permission:pir-siaf']]);
        Route::post('/ejecucionmeta_proyecto', ['uses' => 'siaf\SiafController@ejecucionmeta_proyecto', 'middleware' => ['permission:pir-siaf']]);
        Route::post('/ejecucionmeta_proyecto_siaf', ['uses' => 'siaf\SiafController@ejecucionmeta_proyecto_siaf', 'middleware' => ['permission:pir-siaf']]);
        Route::post('/ejecucionmeta_uei', ['uses' => 'siaf\SiafController@ejecucionmeta_uei', 'middleware' => ['permission:pir-siaf']]);
        Route::post('/ejecucionmeta_uei_siaf', ['uses' => 'siaf\SiafController@ejecucionmeta_uei_siaf', 'middleware' => ['permission:pir-siaf']]);
        Route::post('/show', ['uses' => 'siaf\SiafController@show', 'middleware' => ['permission:pir-siaf']]);
    });

    // Metas (solo administrador)
    Route::group(['prefix' => '/metas', 'middleware' => ['role:admin']], function () {
        Route::get('/proyecto', ['uses' => 'MetaController@proyectoIndex']);
        Route::post('/proyecto/import', ['uses' => 'MetaController@proyectoImport']);
        Route::post('/proyecto/sheets', ['uses' => 'MetaController@proyectoSheets']);
        Route::post('/proyecto/delete-fecha', ['uses' => 'MetaController@proyectoDeleteByFecha']);

        Route::get('/grl', ['uses' => 'MetaController@grlIndex']);
        Route::post('/grl/import', ['uses' => 'MetaController@grlImport']);
        Route::post('/grl/sheets', ['uses' => 'MetaController@grlSheets']);
        Route::post('/grl/delete-fecha', ['uses' => 'MetaController@grlDeleteByFecha']);
    });

