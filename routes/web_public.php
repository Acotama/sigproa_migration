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
