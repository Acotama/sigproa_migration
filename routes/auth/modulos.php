<?php

    // PROYECTOS

use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => '/proyecto'], function () {
        Route::get('/inicio', [\sayhuite\Http\Controllers\ProyectoController::class, 'index'])->middleware(['permission:pir-proyectoinversionagrupado']);
        Route::post('/table_financiera', [\sayhuite\Http\Controllers\ProyectoController::class, 'table_financiera'])->middleware(['permission:pir-proyectoinversion']);
        Route::get('/table_financiera_exportar', [\sayhuite\Http\Controllers\ProyectoController::class, 'table_financiera_exportar'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/table_mes_financiera', [\sayhuite\Http\Controllers\ProyectoController::class, 'table_mes_financiera'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/lineFinanciera', [\sayhuite\Http\Controllers\ProyectoController::class, 'lineFinanciera'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/show', [\sayhuite\Http\Controllers\ProyectoController::class, 'show'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/showpry', [\sayhuite\Http\Controllers\ProyectoController::class, 'showpry'])->middleware(['permission:pir-proyectoinversion']);
        Route::get('/abrirproyecto', [\sayhuite\Http\Controllers\ProyectoController::class, 'abrirproyecto'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/showMeta', [\sayhuite\Http\Controllers\ProyectoController::class, 'showMeta'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/showFuente', [\sayhuite\Http\Controllers\ProyectoController::class, 'showFuente'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/ejecucionmeta', [\sayhuite\Http\Controllers\ProyectoController::class, 'ejecucionmeta'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/showprydev', [\sayhuite\Http\Controllers\ProyectoController::class, 'showprydev'])->middleware(['permission:pir-proyectoinversion']);
        //Seguimiento de Inversiones
        Route::post('/reporte_inversiones', [\sayhuite\Http\Controllers\ProyectoController::class, 'reporte_inversiones'])->middleware(['permission:pir-proyectoinversion']);
        Route::get('/historia_anio', [\sayhuite\Http\Controllers\ProyectoController::class, 'historia_anio'])->middleware(['permission:pir-proyectoinversion']);
        //Lista de Proyecto
        Route::get('/lista_proyecto', [\sayhuite\Http\Controllers\ProyectoController::class, 'lista_proyecto'])->middleware(['permission:pir-proyectoinversion']);
        Route::post('/lista_proyecto_data', [\sayhuite\Http\Controllers\ProyectoController::class, 'lista_proyecto_data'])->middleware(['permission:pir-proyectoinversion']);
    });

    Route::group(['prefix' => '/actividad'], function () {
        Route::get('/', [\sayhuite\Http\Controllers\p_actividadController::class, 'inicio'])->middleware(['permission:pir-ejecucionfinanciera']);
        Route::get('/datos', [\sayhuite\Http\Controllers\p_actividadController::class, 'datos'])->middleware(['permission:pir-ejecucionfinanciera']);
    });

    Route::group(['prefix' => '/procedimiento'], function () {
        Route::get('/nuevo2', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'inicio']);
        Route::post('/datos', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'datos']);
        Route::get('/datosjson', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'datosjson']);
        Route::post('/datosproyecto', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'datosproyecto']);
        Route::post('/datosrequerimientos', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'datosrequerimientos']);
        Route::post('/datosrequerimientosfiltro', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'datosrequerimientosfiltro']);
        Route::get('/subir', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'subir']);
        Route::post('/guardar', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'guardar']);
        Route::post('/guardarf', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'guardar_formulario']);
        Route::get('/nuevo', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'nuevo']);
        Route::get('/exportar', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'exportar_excel']);
        Route::get('/resumen', [\sayhuite\Http\Controllers\ProcedimientoController::class, 'resumen']);
    });

    Route::group(['prefix' => '/contratacionesps'], function () {
        Route::get('/', [\sayhuite\Http\Controllers\ContratacionesController::class, 'inicio'])->middleware(['permission:pir-contrataciones']);
        Route::post('/data', [\sayhuite\Http\Controllers\ContratacionesController::class, 'data'])->middleware(['permission:pir-contrataciones']);
        Route::post('/show', [\sayhuite\Http\Controllers\ContratacionesController::class, 'show'])->middleware(['permission:pir-contrataciones']);
        Route::post('/showpry', [\sayhuite\Http\Controllers\ContratacionesController::class, 'showpry'])->middleware(['permission:pir-contrataciones']);
    });


    Route::group(['prefix' => '/carterapmi'], function () {
        Route::get('/', [\sayhuite\Http\Controllers\CarteraPMIController::class, 'inicio'])->middleware(['permission:pir-pmi']);
        Route::get('/datos', [\sayhuite\Http\Controllers\CarteraPMIController::class, 'datos'])->middleware(['permission:pir-pmi']);
    });

    Route::group(['prefix' => '/formato12b'], function () {
        Route::get('/', [\sayhuite\Http\Controllers\formato12bController::class, 'inicio'])->middleware(['permission:pir-formato12b']);
        Route::post('/datos', [\sayhuite\Http\Controllers\formato12bController::class, 'datos'])->middleware(['permission:pir-formato12b']);
        Route::post('/actualizacion', [\sayhuite\Http\Controllers\formato12bController::class, 'actualizacion_f12b'])->middleware(['permission:pir-formato12b']);
        Route::post('/data', [\sayhuite\Http\Controllers\formato12bController::class, 'datos_f12b'])->middleware(['permission:pir-formato12b']);
        Route::get('/reporte', [\sayhuite\Http\Controllers\formato12bController::class, 'reporte'])->middleware(['permission:pir-formato12b']);
        Route::post('/showpry', [\sayhuite\Http\Controllers\formato12bController::class, 'showpry'])->middleware(['permission:pir-formato12b']);
        Route::post('/showpryET', [\sayhuite\Http\Controllers\formato12bController::class, 'showpryET'])->middleware(['permission:pir-formato12b']);
        Route::post('/showpryETDetalle', [\sayhuite\Http\Controllers\formato12bController::class, 'showpryETDetalle'])->middleware(['permission:pir-formato12b']);
        Route::get('/exportar', [\sayhuite\Http\Controllers\formato12bController::class, 'exportar'])->middleware(['permission:pir-formato12b']);
    });

    Route::group(['prefix' => '/gore'], function () {
        Route::get('/goreejecutivo', [\sayhuite\Http\Controllers\GoreController::class, 'goreejecutivo']);
        Route::post('/goreejecutivocargar', [\sayhuite\Http\Controllers\GoreController::class, 'goreejecutivocargar']);
        Route::get('/goreejecutivoagenda', [\sayhuite\Http\Controllers\GoreController::class, 'goreejecutivoagenda']);
        Route::post('/goreejecutivoagendacargar', [\sayhuite\Http\Controllers\GoreController::class, 'goreejecutivoagendacargar']);
        Route::post('/goreejecutivoagendatranferencia', [\sayhuite\Http\Controllers\GoreController::class, 'ver_trans_asig_nacional']);
    });

    Route::group(['prefix' => '/acta'], function () {
        Route::get('/inicio', [\sayhuite\Http\Controllers\ActaController::class, 'inicio'])->middleware(['permission:pir-actaseguimiento']);
        Route::post('/acuerdos', [\sayhuite\Http\Controllers\ActaController::class, 'acuerdos'])->middleware(['permission:pir-actaseguimiento']);
    });

    // Route::group(['prefix' => '/habilitador'], function () {
    //     Route::get('/inicio', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'inicio'],'middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/anulacion', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'anulacion'],'middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/credito', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'credito'],'middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/agregar', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'agregar'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/data', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'data'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/insertardata', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'insertardata'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/eliminardata', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'eliminardata'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::get('/art', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'analisis'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/data_analisis', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'data_analisis'],'middleware' => ['permission:pir-habilitador-mant']]);
    // });

    // Route::group(['prefix' => '/habilitador'], function () {
    //     Route::get('/inicio', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'inicio'],'middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/anulacion', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'anulacion'],'middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/credito', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'credito'],'middleware' => ['permission:pir-habilitador']]);
    //     Route::post('/agregar', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'agregar'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/data', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'data'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/insertardata', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'insertardata'],'middleware' => ['permission:pir-habilitador-mant']]);
    //     Route::post('/eliminardata', ['uses' => [\sayhuite\Http\Controllers\HabilitadoresController::class, 'eliminardata'],'middleware' => ['permission:pir-habilitador-mant']]);
    // });

    Route::group(['prefix' => '/modificacion_presupuestal'], function () {
        Route::get('/generar', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'modificacion_presupuestal'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::get('/data_analisis', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'data_analisis'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::get('/exportar', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'exportar'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::get('/lista', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'lista'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::get('/data', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'listadata'])->middleware(['permission:pir-modificacion_presupuestal']);

        Route::get('/inicio', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'inicio'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/modal_importar', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'modal_importar'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/importar', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'importar'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/consulta_modificacion', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'consulta_modificacion'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/exportarreporte', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'exportarreporte'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/buscarproyecto', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'buscarproyecto'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/guardar', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'guardar'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/buscardocumento', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'buscardocumento'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/ver_modificacion', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'ver_modificacion'])->middleware(['permission:pir-modificacion_presupuestal']);
        Route::post('/eliminar', [\sayhuite\Http\Controllers\ModificacionPresupuestalController::class, 'eliminar'])->middleware(['permission:pir-modificacion_presupuestal']);
    });

    Route::group(['prefix' => '/noprevistas'], function () {
        Route::get('/inicio', [\sayhuite\Http\Controllers\NoPrevistasController::class, 'inicio'])->middleware(['permission:pir-noprevistas']);
        // Route::post('/data', ['uses' => [\sayhuite\Http\Controllers\NoPrevistasController::class, 'noprevistas'],'middleware' => ['permission:pir-noprevistas']]);
        Route::post('/data', [\sayhuite\Http\Controllers\NoPrevistasController::class, 'data'])->middleware(['permission:pir-noprevistas']);
        Route::post('/agregar', [\sayhuite\Http\Controllers\NoPrevistasController::class, 'agregar'])->middleware(['permission:pir-noprevistas-mant']);
        Route::post('/insertardata', [\sayhuite\Http\Controllers\NoPrevistasController::class, 'insertardata'])->middleware(['permission:pir-noprevistas-mant']);
        Route::post('/eliminardata', [\sayhuite\Http\Controllers\NoPrevistasController::class, 'eliminardata'])->middleware(['permission:pir-noprevistas-mant']);
    });

    Route::group(['prefix' => '/consultamigable'], function () {
        Route::get('/', [\sayhuite\Http\Controllers\ConsultamigableController::class, 'inicio'])->middleware(['permission:pir-consultamigable']);
    });

    /*
    * CHECK SESSION
    */
    Route::get('check-session', [\sayhuite\Http\Controllers\HomeController::class, 'checkSession']);

    // Route::get('enviocorreo', function () {
    Route::group(['prefix' => '/enviocorreo'], function () {
        Route::post('/reportediario', [\sayhuite\Http\Controllers\EnviocorreoController::class, 'GuardarImagen']);
        // $correo = new MensajeRecibido;
        // Mail::to('frankazaneroramirez@gmail.com')->send($correo);

        // return "Mensaje Enviado";
    });

    // SIAF
    Route::group(['prefix' => '/siaf'], function () {
        Route::get('/', [\sayhuite\Http\Controllers\siaf\SiafController::class, 'inicio'])->middleware(['permission:pir-siaf']);
        Route::post('/ejecucionmeta_proyecto', [\sayhuite\Http\Controllers\siaf\SiafController::class, 'ejecucionmeta_proyecto'])->middleware(['permission:pir-siaf']);
        Route::post('/ejecucionmeta_proyecto_siaf', [\sayhuite\Http\Controllers\siaf\SiafController::class, 'ejecucionmeta_proyecto_siaf'])->middleware(['permission:pir-siaf']);
        Route::post('/ejecucionmeta_uei', [\sayhuite\Http\Controllers\siaf\SiafController::class, 'ejecucionmeta_uei'])->middleware(['permission:pir-siaf']);
        Route::post('/ejecucionmeta_uei_siaf', [\sayhuite\Http\Controllers\siaf\SiafController::class, 'ejecucionmeta_uei_siaf'])->middleware(['permission:pir-siaf']);
        Route::post('/show', [\sayhuite\Http\Controllers\siaf\SiafController::class, 'show'])->middleware(['permission:pir-siaf']);
    });

    // Metas (solo administrador)
    Route::group(['prefix' => '/metas', 'middleware' => ['role:admin']], function () {
        Route::get('/proyecto', [\sayhuite\Http\Controllers\MetaController::class, 'proyectoIndex']);
        Route::post('/proyecto/import', [\sayhuite\Http\Controllers\MetaController::class, 'proyectoImport']);
        Route::post('/proyecto/sheets', [\sayhuite\Http\Controllers\MetaController::class, 'proyectoSheets']);
        Route::post('/proyecto/delete-fecha', [\sayhuite\Http\Controllers\MetaController::class, 'proyectoDeleteByFecha']);

        Route::get('/grl', [\sayhuite\Http\Controllers\MetaController::class, 'grlIndex']);
        Route::post('/grl/import', [\sayhuite\Http\Controllers\MetaController::class, 'grlImport']);
        Route::post('/grl/sheets', [\sayhuite\Http\Controllers\MetaController::class, 'grlSheets']);
        Route::post('/grl/delete-fecha', [\sayhuite\Http\Controllers\MetaController::class, 'grlDeleteByFecha']);
    });

