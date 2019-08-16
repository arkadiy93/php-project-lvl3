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
use DiDom\Document;

$router->get('/', ['as' => 'index', function () {
    return view('index');
}]);

$router->post('/domains', ['as' => 'domains.store', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'url' => 'required|url',
    ]);

    if ($validator->fails()) {
        $urlError = $validator->errors()->first('url');
        $errors = ['url' => $urlError];
        return view('index', ['errors' => $errors]);
    }
    
    $url = $request->get('url');
    $client = app(Client::class);
    $response = $client->get($url);

    $body = $response->getBody()->getContents();
    $code = $response->getStatusCode();
    $contentLengthHeader = $response->getHeader('Content-Length')[0] ?? 'no data';
    
    $domains = new Domains();
    $domains->name = $url;
    $domains->body = $body;
    
    $document = new Document($body);
    $domains->heading = $document->has('h1') ? $document->find('h1')[0]->text() : 'no data';
    $domains->description = $document->find('meta[name=description]::attr(content)')[0] ?? 'no data';
    $domains->keywords = $document->find('meta[name=keywords]::attr(content)')[0] ?? 'no data';
    
    $domains->status_code = $code;
    $domains->content_length = $contentLengthHeader;
    $domains->save();

    $id = $domains->id;
    return redirect()->route('domains.show', ['id' => $id]);
}]);

$router->get('/domains/{id}', ['as' => 'domains.show', function ($id) {
    $domain = Domains::find($id);
    return view('list', ['domains' => [$domain]]);
}]);

$router->get('/domains', ['as' => 'domains.index' , function () {
    $domains = Domains::paginate(5);
    return view('list', ['domains' => $domains]);
}]);
