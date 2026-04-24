<?php

    //PIP TOTAL PRIORI

use Illuminate\Support\Facades\Route;

    Route::get('piptotalpriori', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'index'])->middleware(['permission:pi-list']);
    //Route::get('piptotalpriori/create',['uses' =>  [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'create'],'middleware' => ['permission:pi-create']]);
    //Route::post('piptotalpriori/store',['uses' =>  [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'store'],'middleware' => ['permission:pi-store']]);
    Route::post('piptotalpriori/show', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'show'])->middleware(['permission:pi-show']);
    Route::get('piptotalpriori/edit/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'edit'])->middleware(['permission:pi-edit']);
    //>>>>
    Route::post('piptotalpriori/codexists', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'codExists'])->middleware(['permission:pi-list']);
    Route::post('piptotalpriori/update/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'update'])->middleware(['permission:pi-update']);
    Route::get('piptotalpriori/destroy/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'destroy'])->middleware(['permission:pi-delete']);
    Route::get('piptotalpriori/combodistrito/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'combodistrito']);
    Route::get('piptotalpriori/combosubetapa/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'combosubetapa']);
    Route::get('piptotalpriori/buscacontrato', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'buscacontrato']);
    //>>>>Detail
    Route::post('/pipInv', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'DetalleInversion'])->middleware(['permission:pi-list']);
    //>>>>Search
    Route::post('/getSearchOpt', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getSearchOpt'])->middleware(['permission:pi-list']);
    //>>>>Count
    Route::post('/getCount', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getCount'])->middleware(['permission:pi-list']);
    //>>>>State
    Route::post('/stateSayhuite', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'stateSayhuite'])->middleware(['permission:sayhuite-state']);
    //>>>>Filter
    Route::post('/filter-data', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'filterData'])->middleware(['permission:pi-list']);
    //>>>>Select Pi
    Route::post('piptotalpriori/selectpi', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'selectPi']);
    Route::post('piptotalpriori/selectpi-update', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'selectPiUpdate'])->middleware(['permission:pi-list']);
    //>>>>PdfExport
    Route::get('piptotalpriori/pdfExport/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'pdfExport'])->middleware(['permission:pi-list']);
    //>>>>WordExport
    Route::get('piptotalpriori/wordExport/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'wordExport'])->middleware(['permission:pi-list']);

    Route::get('piptotalpriori/pdfExportHistory/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'exportHistory'])->middleware(['permission:pi-list']);
    //>>>>History
    Route::get('piptotalpriori/history/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'history'])->middleware(['permission:pi-list']);
    //>>>>History Finance
    Route::get('piptotalpriori/historyf/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'historyFinance'])->middleware(['permission:pi-list']);
    //IMAGES
    Route::any('/imgUpload', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'imgUpload'])->middleware(['permission:image-upload'])->name('upload-post');
    Route::get('/getServer-images/{uid}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getServerImages'])->middleware(['permission:image-list'])->name('server-images');

    Route::get('/getServer-images2/{uid}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getServerImages2'])->middleware(['permission:image-list'])->name('server-images');
    Route::get('/piptotalpriori/getEditImage/{uid}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getEditServerImages'])->middleware(['permission:pi-edit'])->name('edit-server-images');
    Route::post('/piptotalpriori/updateImage/{uid}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'updateImage'])->middleware(['permission:pi-edit'])->name('update-server-images');
    Route::get('/piptotalpriori/getPackImage/{uid}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getImagePack'])->name('server-images-pack');

    Route::POST('/piptotalpriori/deleteImagePack/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'deleteImagePack'])->middleware(['permission:pi-edit'])->name('server-images-pack');

    Route::GET('/piptotalpriori/getMetas/{id}', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getMetas'])->name('get-metas');

    //PDF
    Route::any('/pdfUpload', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'uploadPdf'])->middleware(['permission:pdf-upload'])->name('upload-pdf');
    //LOCATION
    Route::post('/getLocationInfo', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'getLocationInfo']);
    Route::post('/updateLocationInfo', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'updateLocationInfo']);
    //TOTAL PRIORI ACTUALIZAR
    Route::post('/update_datos_TotalPriori', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'update_datos_TotalPriori'])->middleware(['permission:pi-update']);


    Route::get('/piptotalpriori/proyecto/estado/filter', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'filterEstadoProyecto']);
    Route::post('/piptotalpriori/proyecto/estado/delete', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'deleteEstadoProyecto']);



    //CRONOGRAMA

    Route::get('/piptotalpriori/cronograma/{idproyecto}', [\sayhuite\Http\Controllers\CronogramaController::class, 'index']);
    Route::get('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}', [\sayhuite\Http\Controllers\CronogramaController::class, 'get']);
    Route::resource('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}/link', 'LinkController');
    Route::resource('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}/task', 'TaskController');

