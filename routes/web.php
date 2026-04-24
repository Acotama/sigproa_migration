<?php

use sayhuite\Mail\MensajeRecibido;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*Route::get('/', function () {
    return view('test.test');
});*/

Route::get('/', 'HomeController@index');

//Route::get('/hashimg', 'TService@hashimg');

//Route::get('/console', 'PipTotalPrioriController@console');

/*Route::get('/pusher', function(){
    event(new sayhuite\Events\HelloPusherEvent('Hi there Pusher!'));
    return "Event has been sent!";
});*/


Route::view('/testing', 'test.test');



//Route::get('/service', 'HomeController@service');

Route::get('login', 'HomeController@login');
Route::post('login', 'HomeController@postLogin');

//REGISTRO
Route::get('registro', 'HomeController@registro');
Route::post('registro', 'HomeController@registroCreate');

//PASSWORD
Route::get('email', 'HomeController@email');
Route::post('email', 'HomeController@emailEnviar');

//CONTACTO
Route::get('mensaje', 'HomeController@contacto');
Route::post('mensaje', 'HomeController@contactoCreate');

Route::get('combo/{id1}/{id2}', 'HomeController@combo')->where(array('id1' => '[0-9]+', 'id2' => '[0-9]+'));
Route::get('acerca', 'HomeController@acerca');


Route::any('etInfo', 'HomeController@insertInfo');

Route::group(['prefix' => '/resumen'], function () {
    Route::get('/', 'HomeController@resumen');
    Route::post('ejecucionmeta', 'ProyectoController@ejecucionmeta');
    Route::post('financiera', 'StatsController@lineFinanciera');
    Route::post('ranking', 'StatsController@ranking');
    Route::get('historia_anio', 'ProyectoController@historia_anio');
    Route::post('/showprydev', 'ProyectoController@showprydev');
});

Route::group(['prefix' => '/resumen1'], function () {
    Route::get('/', 'HomeController@resumen1');
    Route::post('ejecucionmeta', 'ProyectoController@ejecucionmeta');
    Route::post('financiera', 'StatsController@lineFinanciera');
    Route::post('ranking', 'StatsController@ranking');
    Route::get('historia_anio', 'ProyectoController@historia_anio');
    Route::post('/showprydev', 'ProyectoController@showprydev');
});

Route::group(['prefix' => '/apigore'], function () {
    Route::get('/lista_inversion', 'ApiController@lista_inversion');
    Route::get('/lista', 'ApiController@lista');
    Route::get('/lista_total', 'ApiController@lista_total');
});

Route::group(['prefix' => '/apimef'], function () {
    Route::get('/ssi/{id}', 'ApiMefController@ssi');
    Route::get('/f12b/{id}', 'ApiMefController@f12b');
    Route::get('/pmi/{id}', 'ApiMefController@pmi');
    Route::get('/formato08/{id}', 'ApiMefController@formato08');
});

Route::group(array('middleware' => 'auth'), function () {

    // if(env('APP_ENV') == 'production'){
    //     URL::forceSchema('https');
    // }
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
    //PIP TOTAL PRIORI
    Route::get('piptotalpriori', ['uses' => 'PipTotalPrioriController@index', 'middleware' => ['permission:pi-list']]);
    //Route::get('piptotalpriori/create',['uses' =>  'PipTotalPrioriController@create','middleware' => ['permission:pi-create']]);
    //Route::post('piptotalpriori/store',['uses' =>  'PipTotalPrioriController@store','middleware' => ['permission:pi-store']]);
    Route::post('piptotalpriori/show', ['uses' =>  'PipTotalPrioriController@show', 'middleware' => ['permission:pi-show']]);
    Route::get('piptotalpriori/edit/{id}', ['uses' =>  'PipTotalPrioriController@edit', 'middleware' => ['permission:pi-edit']]);
    //>>>>
    Route::post('piptotalpriori/codexists', ['uses' => 'PipTotalPrioriController@codExists', 'middleware' => ['permission:pi-list']]);
    Route::post('piptotalpriori/update/{id}', ['uses' =>  'PipTotalPrioriController@update', 'middleware' => ['permission:pi-update']]);
    Route::get('piptotalpriori/destroy/{id}', ['uses' =>  'PipTotalPrioriController@destroy', 'middleware' => ['permission:pi-delete']]);
    Route::get('piptotalpriori/combodistrito/{id}', ['uses' =>  'PipTotalPrioriController@combodistrito']);
    Route::get('piptotalpriori/combosubetapa/{id}', ['uses' =>  'PipTotalPrioriController@combosubetapa']);
    Route::get('piptotalpriori/buscacontrato', ['uses' =>  'PipTotalPrioriController@buscacontrato']);
    //>>>>Detail
    Route::post('/pipInv', ['uses' =>  'PipTotalPrioriController@DetalleInversion', 'middleware' => ['permission:pi-list']]);
    //>>>>Search
    Route::post('/getSearchOpt', ['uses' =>  'PipTotalPrioriController@getSearchOpt', 'middleware' => ['permission:pi-list']]);
    //>>>>Count
    Route::post('/getCount', ['uses' =>  'PipTotalPrioriController@getCount', 'middleware' => ['permission:pi-list']]);
    //>>>>State
    Route::post('/stateSayhuite', ['uses' =>  'PipTotalPrioriController@stateSayhuite', 'middleware' => ['permission:sayhuite-state']]);
    //>>>>Filter
    Route::post('/filter-data', ['uses' =>  'PipTotalPrioriController@filterData', 'middleware' => ['permission:pi-list']]);
    //>>>>Select Pi
    Route::post('piptotalpriori/selectpi', ['uses' =>  'PipTotalPrioriController@selectPi']);
    Route::post('piptotalpriori/selectpi-update', ['uses' =>  'PipTotalPrioriController@selectPiUpdate', 'middleware' => ['permission:pi-list']]);
    //>>>>PdfExport
    Route::get('piptotalpriori/pdfExport/{id}', ['uses' =>  'PipTotalPrioriController@pdfExport', 'middleware' => ['permission:pi-list']]);
    //>>>>WordExport
    Route::get('piptotalpriori/wordExport/{id}', ['uses' =>  'PipTotalPrioriController@wordExport', 'middleware' => ['permission:pi-list']]);

    Route::get('piptotalpriori/pdfExportHistory/{id}', ['uses' =>  'PipTotalPrioriController@exportHistory', 'middleware' => ['permission:pi-list']]);
    //>>>>History
    Route::get('piptotalpriori/history/{id}', ['uses' =>  'PipTotalPrioriController@history', 'middleware' => ['permission:pi-list']]);
    //>>>>History Finance
    Route::get('piptotalpriori/historyf/{id}', ['uses' =>  'PipTotalPrioriController@historyFinance', 'middleware' => ['permission:pi-list']]);
    //IMAGES
    Route::any('/imgUpload', ['as' => 'upload-post', 'uses' => 'PipTotalPrioriController@imgUpload', 'middleware' => ['permission:image-upload']]);
    Route::get('/getServer-images/{uid}', ['as' => 'server-images', 'uses' => 'PipTotalPrioriController@getServerImages', 'middleware' => ['permission:image-list']]);

    Route::get('/getServer-images2/{uid}', ['as' => 'server-images', 'uses' => 'PipTotalPrioriController@getServerImages2', 'middleware' => ['permission:image-list']]);
    Route::get('/piptotalpriori/getEditImage/{uid}', ['as' => 'edit-server-images', 'uses' => 'PipTotalPrioriController@getEditServerImages', 'middleware' => ['permission:pi-edit']]);
    Route::post('/piptotalpriori/updateImage/{uid}', ['as' => 'update-server-images', 'uses' => 'PipTotalPrioriController@updateImage', 'middleware' => ['permission:pi-edit']]);
    Route::get('/piptotalpriori/getPackImage/{uid}', ['as' => 'server-images-pack', 'uses' => 'PipTotalPrioriController@getImagePack']);

    Route::POST('/piptotalpriori/deleteImagePack/{id}', ['as' => 'server-images-pack', 'uses' => 'PipTotalPrioriController@deleteImagePack', 'middleware' => ['permission:pi-edit']]);

    Route::GET('/piptotalpriori/getMetas/{id}', ['as' => 'get-metas', 'uses' => 'PipTotalPrioriController@getMetas']);

    //PDF
    Route::any('/pdfUpload', ['as' => 'upload-pdf', 'uses' => 'PipTotalPrioriController@uploadPdf', 'middleware' => ['permission:pdf-upload']]);
    //LOCATION
    Route::post('/getLocationInfo', ['uses' =>  'PipTotalPrioriController@getLocationInfo']);
    Route::post('/updateLocationInfo', ['uses' =>  'PipTotalPrioriController@updateLocationInfo']);
    //TOTAL PRIORI ACTUALIZAR
    Route::post('/update_datos_TotalPriori', ['uses' =>  'PipTotalPrioriController@update_datos_TotalPriori', 'middleware' => ['permission:pi-update']]);


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

    Route::get('/piptotalpriori/proyecto/estado/filter', ['uses' => 'PipTotalPrioriController@filterEstadoProyecto']);
    Route::post('/piptotalpriori/proyecto/estado/delete', ['uses' => 'PipTotalPrioriController@deleteEstadoProyecto']);



    //CRONOGRAMA

    Route::get('/piptotalpriori/cronograma/{idproyecto}', ['uses' =>  'CronogramaController@index']);
    Route::get('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}', ['uses' =>  'CronogramaController@get']);
    Route::resource('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}/link', 'LinkController');
    Route::resource('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}/task', 'TaskController');

    //MANTENIMIENTO DE CANALES - mantcanales
    Route::get('/mantcanales', ['uses' => 'MantCanalesController@index', 'middleware' => ['permission:mantcanales-list']]);
    Route::get('/mantcanales/create', ['uses' =>  'MantCanalesController@create', 'middleware' => ['permission:mantcanales-update']]);
    Route::post('/mantcanales/store', ['uses' =>  'MantCanalesController@store', 'middleware' => ['permission:mantcanales-update']]);
    Route::post('/mantcanales/show', ['uses' =>  'MantCanalesController@show', 'middleware' => ['permission:mantcanales-show']]);
    Route::post('/mantcanales/update', ['uses' =>  'MantCanalesController@update', 'middleware' => ['permission:mantcanales-update']]);
    //>>>>State
    Route::post('/stateSayhuiteMantCanales', ['uses' =>  'MantCanalesController@stateSayhuite', 'middleware' => ['permission:mancanales-list']]);
    //>>>>Filter
    Route::post('/filter-data-mantcanales', ['as' => 'fd-mantcanales', 'uses' =>  'MantCanalesController@filterData', 'middleware' => ['permission:mantcanales-list']]);
    //>>>>LOCATION
    Route::post('/mantcanales/location', ['uses' =>  'MantCanalesController@getLocationPage']);
    Route::post('/mantcanales-getLocationInfo', ['uses' =>  'MantCanalesController@getLocationInfo']);
    Route::post('/mantcanales-updateLocationInfo', ['uses' =>  'MantCanalesController@updateLocationInfo']);
    //PDF
    Route::post('/mantcanales/pdf', ['uses' => 'MantCanalesController@getPagePdfUpload']);
    Route::any('/mantcanales/fileUpload', ['as' => 'mantcanales-upload-pdf', 'uses' => 'MantCanalesController@postUploadPdf']);
    Route::get('/mantcanales-server-pdf/{uid}', ['as' => 'mantcanales-server-pdf', 'uses' => 'MantCanalesController@getServerPdf']);
    Route::any('/mantcanales-delete-pdf', ['as' => 'delete-pdf', 'uses' => 'MantCanalesController@deletePdf']);
    //IMAGES
    Route::post('/mantcanales/images', ['uses' => 'MantCanalesController@getPageImageUpload']);
    Route::any('/mantcanales/images/upload', ['as' => 'upload-post', 'uses' => 'MantCanalesController@imgUpload']);
    Route::get('/mantcanales/server-images/{uid}', ['as' => 'server-images', 'uses' => 'MantCanalesController@getServerImages']);


    //PROCOMPITE -procompite
    Route::get('procompite', ['uses' => 'ProcompiteController@index']);
    Route::post('procompite/show', ['uses' =>  'ProcompiteController@show']);
    Route::post('procompite/update', ['uses' =>  'ProcompiteController@update']);
    //>>>>State
    Route::post('/stateSayhuiteProcompite', ['uses' =>  'ProcompiteController@stateSayhuite']);
    //>>>>Filter
    Route::post('/filter-data-procompite', ['as' => 'fd-procompite', 'uses' =>  'ProcompiteController@filterData']);
    //>>>>LOCATION
    Route::post('/procompite/location', ['uses' =>  'ProcompiteController@getLocationPage']);
    Route::post('/procompite-getLocationInfo', ['uses' =>  'ProcompiteController@getLocationInfo']);
    Route::post('/procompite-updateLocationInfo', ['uses' =>  'ProcompiteController@updateLocationInfo']);
    //PDF
    Route::post('procompite/pdf', ['uses' => 'ProcompiteController@getPagePdfUpload']);
    Route::any('procompite/fileUpload', ['as' => 'procompite-upload-pdf', 'uses' => 'ProcompiteController@postUploadPdf']);
    Route::get('procompite-server-pdf/{uid}', ['as' => 'procompite-server-pdf', 'uses' => 'ProcompiteController@getServerPdf']);
    Route::any('procompite-delete-pdf', ['as' => 'delete-pdf', 'uses' => 'ProcompiteController@deletePdf']);
    //IMAGES
    Route::post('procompite/images', ['uses' => 'ProcompiteController@getPageImageUpload']);
    Route::any('procompite/images/upload', ['as' => 'upload-post', 'uses' => 'ProcompiteController@imgUpload']);
    Route::get('procompite/server-images/{uid}', ['as' => 'server-images', 'uses' => 'ProcompiteController@getServerImages']);

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

    Route::group(['prefix' => '/prueba'], function () {
        Route::get('/', ['uses' => 'PruebaController@inicio']);
        Route::post('/guardar', ['uses' => 'PruebaController@guardar_actividadoperativa']);
        Route::get('/datos', ['uses' => 'PruebaController@datos']);
        Route::post('modal', ['uses' => 'PruebaController@modal_agregar', 'middleware' => ['permission:user-create']]);
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

    // routes/web.php
    Route::get('/run-python', 'PythonController@run');

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


    /*
     * WEB SERVICE
     */
});

//Route::resource('api','TService');
