<?php

    //MANTENIMIENTO DE CANALES - mantcanales

use Illuminate\Support\Facades\Route;

    Route::get('/mantcanales', [\sayhuite\Http\Controllers\MantCanalesController::class, 'index'])->middleware(['permission:mantcanales-list']);
    Route::get('/mantcanales/create', [\sayhuite\Http\Controllers\MantCanalesController::class, 'create'])->middleware(['permission:mantcanales-update']);
    Route::post('/mantcanales/store', [\sayhuite\Http\Controllers\MantCanalesController::class, 'store'])->middleware(['permission:mantcanales-update']);
    Route::post('/mantcanales/show', [\sayhuite\Http\Controllers\MantCanalesController::class, 'show'])->middleware(['permission:mantcanales-show']);
    Route::post('/mantcanales/update', [\sayhuite\Http\Controllers\MantCanalesController::class, 'update'])->middleware(['permission:mantcanales-update']);
    //>>>>State
    Route::post('/stateSayhuiteMantCanales', [\sayhuite\Http\Controllers\MantCanalesController::class, 'stateSayhuite'])->middleware(['permission:mancanales-list']);
    //>>>>Filter
    Route::post('/filter-data-mantcanales', [\sayhuite\Http\Controllers\MantCanalesController::class, 'filterData'])->middleware(['permission:mantcanales-list'])->name('fd-mantcanales');
    //>>>>LOCATION
    Route::post('/mantcanales/location', [\sayhuite\Http\Controllers\MantCanalesController::class, 'getLocationPage']);
    Route::post('/mantcanales-getLocationInfo', [\sayhuite\Http\Controllers\MantCanalesController::class, 'getLocationInfo']);
    Route::post('/mantcanales-updateLocationInfo', [\sayhuite\Http\Controllers\MantCanalesController::class, 'updateLocationInfo']);
    //PDF
    Route::post('/mantcanales/pdf', [\sayhuite\Http\Controllers\MantCanalesController::class, 'getPagePdfUpload']);
    Route::any('/mantcanales/fileUpload', [\sayhuite\Http\Controllers\MantCanalesController::class, 'postUploadPdf'])->name('mantcanales-upload-pdf');
    Route::get('/mantcanales-server-pdf/{uid}', [\sayhuite\Http\Controllers\MantCanalesController::class, 'getServerPdf'])->name('mantcanales-server-pdf');
    Route::any('/mantcanales-delete-pdf', [\sayhuite\Http\Controllers\MantCanalesController::class, 'deletePdf'])->name('delete-pdf');
    //IMAGES
    Route::post('/mantcanales/images', [\sayhuite\Http\Controllers\MantCanalesController::class, 'getPageImageUpload']);
    Route::any('/mantcanales/images/upload', [\sayhuite\Http\Controllers\MantCanalesController::class, 'imgUpload'])->name('upload-post');
    Route::get('/mantcanales/server-images/{uid}', [\sayhuite\Http\Controllers\MantCanalesController::class, 'getServerImages'])->name('server-images');


    //PROCOMPITE -procompite
    Route::get('procompite', [\sayhuite\Http\Controllers\ProcompiteController::class, 'index']);
    Route::post('procompite/show', [\sayhuite\Http\Controllers\ProcompiteController::class, 'show']);
    Route::post('procompite/update', [\sayhuite\Http\Controllers\ProcompiteController::class, 'update']);
    //>>>>State
    Route::post('/stateSayhuiteProcompite', [\sayhuite\Http\Controllers\ProcompiteController::class, 'stateSayhuite']);
    //>>>>Filter
    Route::post('/filter-data-procompite', [\sayhuite\Http\Controllers\ProcompiteController::class, 'filterData'])->name('fd-procompite');
    //>>>>LOCATION
    Route::post('/procompite/location', [\sayhuite\Http\Controllers\ProcompiteController::class, 'getLocationPage']);
    Route::post('/procompite-getLocationInfo', [\sayhuite\Http\Controllers\ProcompiteController::class, 'getLocationInfo']);
    Route::post('/procompite-updateLocationInfo', [\sayhuite\Http\Controllers\ProcompiteController::class, 'updateLocationInfo']);
    //PDF
    Route::post('procompite/pdf', [\sayhuite\Http\Controllers\ProcompiteController::class, 'getPagePdfUpload']);
    Route::any('procompite/fileUpload', [\sayhuite\Http\Controllers\ProcompiteController::class, 'postUploadPdf'])->name('procompite-upload-pdf');
    Route::get('procompite-server-pdf/{uid}', [\sayhuite\Http\Controllers\ProcompiteController::class, 'getServerPdf'])->name('procompite-server-pdf');
    Route::any('procompite-delete-pdf', [\sayhuite\Http\Controllers\ProcompiteController::class, 'deletePdf'])->name('delete-pdf');
    //IMAGES
    Route::post('procompite/images', [\sayhuite\Http\Controllers\ProcompiteController::class, 'getPageImageUpload']);
    Route::any('procompite/images/upload', [\sayhuite\Http\Controllers\ProcompiteController::class, 'imgUpload'])->name('upload-post');
    Route::get('procompite/server-images/{uid}', [\sayhuite\Http\Controllers\ProcompiteController::class, 'getServerImages'])->name('server-images');

