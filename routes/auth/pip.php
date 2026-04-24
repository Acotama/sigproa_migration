<?php

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


    Route::get('/piptotalpriori/proyecto/estado/filter', ['uses' => 'PipTotalPrioriController@filterEstadoProyecto']);
    Route::post('/piptotalpriori/proyecto/estado/delete', ['uses' => 'PipTotalPrioriController@deleteEstadoProyecto']);



    //CRONOGRAMA

    Route::get('/piptotalpriori/cronograma/{idproyecto}', ['uses' =>  'CronogramaController@index']);
    Route::get('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}', ['uses' =>  'CronogramaController@get']);
    Route::resource('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}/link', 'LinkController');
    Route::resource('/piptotalpriori/cronograma/{idproyecto}/meta/{idmeta}/task', 'TaskController');

