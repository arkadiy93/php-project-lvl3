<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', [
    'as' => 'index',
    'uses' => 'AppController@index'
]);

Route::post('/domains', [
    'as' => 'domains.store',
    'uses' => 'DomainsController@store'
]);

Route::get('/domains/{id}', [
    'as' => 'domains.show',
    'uses' => 'DomainsController@show'
]);

Route::get('/domains', [
    'as' => 'domains.index',
    'uses' => 'DomainsController@index'
]);
