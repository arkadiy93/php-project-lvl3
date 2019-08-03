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

use Illuminate\Http\Request;
use App\Domains;
use Illuminate\Support\Facades\DB;

$router->get('/', function () {
    return view('index');
});

$router->post('/domains', function (Request $request) {
    $name = $request->get('url');
    $domains = new Domains();
    $domains->name = $name;
    $domains->save();
    $id = $domains->id;
    return redirect("/domains/$id");
});

$router->get('/domains/{id}', function ($id) {
    $domain = Domains::find($id);
    return view('list', ['name' => $domain->name]);
});
