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
    'uses' => 'DomainsController@initialize'
]);

Route::post('/domains', [
    'as' => 'domains.store',
    'uses' => 'DomainsController@saveDomain'
]);

Route::get('/domains/{id}', [
    'as' => 'domains.show',
    'uses' => 'DomainsController@showDomain'
]);

Route::get('/domains', [
    'as' => 'domains.index',
    'uses' => 'DomainsController@getDomainList'
]);
