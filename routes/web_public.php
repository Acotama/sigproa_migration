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

Route::get('/', [\sayhuite\Http\Controllers\HomeController::class, 'index']);

//Route::get('/console', [\sayhuite\Http\Controllers\PipTotalPrioriController::class, 'console']);

/*Route::get('/pusher', function(){
    event(new sayhuite\Events\HelloPusherEvent('Hi there Pusher!'));
    return "Event has been sent!";
});*/


Route::view('/testing', 'test.test');



//Route::get('/service', [\sayhuite\Http\Controllers\HomeController::class, 'service']);

Route::get('login', [\sayhuite\Http\Controllers\HomeController::class, 'login']);
Route::post('login', [\sayhuite\Http\Controllers\HomeController::class, 'postLogin']);

//REGISTRO
Route::get('registro', [\sayhuite\Http\Controllers\HomeController::class, 'registro']);
Route::post('registro', [\sayhuite\Http\Controllers\HomeController::class, 'registroCreate']);

//PASSWORD
Route::get('email', [\sayhuite\Http\Controllers\HomeController::class, 'email']);
Route::post('email', [\sayhuite\Http\Controllers\HomeController::class, 'emailEnviar']);

//CONTACTO
Route::get('mensaje', [\sayhuite\Http\Controllers\HomeController::class, 'contacto']);
Route::post('mensaje', [\sayhuite\Http\Controllers\HomeController::class, 'contactoCreate']);

Route::get('combo/{id1}/{id2}', [\sayhuite\Http\Controllers\HomeController::class, 'combo'])->where(array('id1' => '[0-9]+', 'id2' => '[0-9]+'));
Route::get('acerca', [\sayhuite\Http\Controllers\HomeController::class, 'acerca']);


Route::any('etInfo', [\sayhuite\Http\Controllers\HomeController::class, 'insertInfo']);

Route::group(['prefix' => '/resumen'], function () {
    Route::get('/', [\sayhuite\Http\Controllers\HomeController::class, 'resumen']);
    Route::post('ejecucionmeta', [\sayhuite\Http\Controllers\ProyectoController::class, 'ejecucionmeta']);
    Route::post('financiera', [\sayhuite\Http\Controllers\StatsController::class, 'lineFinanciera']);
    Route::post('ranking', [\sayhuite\Http\Controllers\StatsController::class, 'ranking']);
    Route::get('historia_anio', [\sayhuite\Http\Controllers\ProyectoController::class, 'historia_anio']);
    Route::post('/showprydev', [\sayhuite\Http\Controllers\ProyectoController::class, 'showprydev']);
});

Route::group(['prefix' => '/resumen1'], function () {
    Route::get('/', [\sayhuite\Http\Controllers\HomeController::class, 'resumen1']);
    Route::post('ejecucionmeta', [\sayhuite\Http\Controllers\ProyectoController::class, 'ejecucionmeta']);
    Route::post('financiera', [\sayhuite\Http\Controllers\StatsController::class, 'lineFinanciera']);
    Route::post('ranking', [\sayhuite\Http\Controllers\StatsController::class, 'ranking']);
    Route::get('historia_anio', [\sayhuite\Http\Controllers\ProyectoController::class, 'historia_anio']);
    Route::post('/showprydev', [\sayhuite\Http\Controllers\ProyectoController::class, 'showprydev']);
});

Route::group(['prefix' => '/apigore'], function () {
    Route::get('/lista_inversion', [\sayhuite\Http\Controllers\ApiController::class, 'lista_inversion']);
    Route::get('/lista', [\sayhuite\Http\Controllers\ApiController::class, 'lista']);
    Route::get('/lista_total', [\sayhuite\Http\Controllers\ApiController::class, 'lista_total']);
});

Route::group(['prefix' => '/apimef'], function () {
    Route::get('/ssi/{id}', [\sayhuite\Http\Controllers\ApiMefController::class, 'ssi']);
    Route::get('/f12b/{id}', [\sayhuite\Http\Controllers\ApiMefController::class, 'f12b']);
    Route::get('/pmi/{id}', [\sayhuite\Http\Controllers\ApiMefController::class, 'pmi']);
    Route::get('/formato08/{id}', [\sayhuite\Http\Controllers\ApiMefController::class, 'formato08']);
});
