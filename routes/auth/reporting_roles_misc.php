<?php

    //EXPORT

use Illuminate\Support\Facades\Route;

    Route::get('/exportar', [\sayhuite\Http\Controllers\ExportController::class, 'index'])->name('rptExportar');
    Route::get('/exportar/{tipo}', [\sayhuite\Http\Controllers\ExportController::class, 'exportar']);
    Route::get('/exportar_proyecto', [\sayhuite\Http\Controllers\ExportController::class, 'exportar_proyecto']);
    Route::get('/exportar_pmi', [\sayhuite\Http\Controllers\ExportController::class, 'exportar_pmi']);
    Route::get('/exportar_proyecto_ff', [\sayhuite\Http\Controllers\ExportController::class, 'exportar_proyecto_ff']);
    Route::get('/reporte_diario', [\sayhuite\Http\Controllers\ExportController::class, 'reporte_prueba']);
    Route::get('/reporte_diario_f12', [\sayhuite\Http\Controllers\ExportController::class, 'reporte_diario_f12']);

    Route::get('/reporte_prueba', [\sayhuite\Http\Controllers\ExportController::class, 'reporte_grafico']);
    Route::get('/reporte_fin_mes', [\sayhuite\Http\Controllers\ExportController::class, 'reporte_diario_fin_mes']);

    Route::post('principal/chart', [\sayhuite\Http\Controllers\PrincipalController::class, 'index']);
    Route::post('principal/dashSearch', [\sayhuite\Http\Controllers\PrincipalController::class, 'dashSearch']);


    Route::get('images', [\sayhuite\Http\Controllers\ImageController::class, 'getServerImagesPage'])->middleware(['permission:image-upload']);
    Route::get('server-images/{uid}', [\sayhuite\Http\Controllers\ImageController::class, 'getServerImages'])->middleware(['permission:image-list'])->name('server-images');
    //PDF
    Route::any('fileUpload', [\sayhuite\Http\Controllers\PdfController::class, 'postUpload'])->middleware(['permission:pdf-upload'])->name('upload-pdf');
    Route::get('server-pdf/{uid}', [\sayhuite\Http\Controllers\PdfController::class, 'getServerPdf'])->middleware(['permission:pdf-list'])->name('server-pdf');
    Route::any('delete-pdf', [\sayhuite\Http\Controllers\PdfController::class, 'deletePdf'])->name('delete-pdf');

    //AUDIT
    Route::post('audit/piptotalpriori/getAuditChanges', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getAuditChanges'])->middleware(['permission:pi-show']);

    //INFORMACION FINANCIERA
    /*
         * TODO
         */
    Route::post('infFinanciera/vwEjecucion', [\sayhuite\Http\Controllers\InfFinancieraController::class, 'loadPartial'])->name('vwEjecucion');
    Route::post('infFinanciera/getEjecucion', [\sayhuite\Http\Controllers\InfFinancieraController::class, 'getResumen'])->name('getEjecucion');
   
    //ROLES
    // Listar roles
    Route::get('roles', [\sayhuite\Http\Controllers\RoleController::class, 'index'])->name('roles.index')->middleware(['permission:role-list']);
    // Formulario crear
    Route::get('roles/create', [\sayhuite\Http\Controllers\RoleController::class, 'create'])->name('roles.create')->middleware(['permission:role-create']);
    // Guardar nuevo rol
    Route::post('roles', [\sayhuite\Http\Controllers\RoleController::class, 'store'])->name('roles.store')->middleware(['permission:role-create']);
    // Ver rol
    Route::get('roles/{id}', [\sayhuite\Http\Controllers\RoleController::class, 'show'])->name('roles.show')->middleware(['permission:role-list']);
    // Formulario editar
    Route::get('roles/{id}/edit', [\sayhuite\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit')->middleware(['permission:role-edit']);
    // Actualizar rol
    Route::patch('roles/{id}', [\sayhuite\Http\Controllers\RoleController::class, 'update'])->name('roles.update')->middleware(['permission:role-edit']);
    // Eliminar rol
    Route::delete('roles/{id}', [\sayhuite\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy')->middleware(['permission:role-delete']);

    Route::post('/getInspectorbyNomOrDNI', [\sayhuite\Http\Controllers\UsuarioController::class, 'getInspectorbyNomOrDNI']);


    //ACTIVIDAD
    Route::post('ActividadOperativa/ActividadOperativaxActividad', [\sayhuite\Http\Controllers\ActividadOperativaController::class, 'listActividadOperativaxActividad']);

    Route::get('getActividadByUsuario/{idusuario?}', [\sayhuite\Http\Controllers\ActividadController::class, 'getActividadByUsuario'])->where(['idusuario' => '[0-9]+']);

    //DISTRITO
    Route::get('/listDistritoByName', [\sayhuite\Http\Controllers\UbigeoController::class, 'listDistritoByName']);

