<?php

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

