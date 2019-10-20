<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domain;
use DiDom\Document;
use GuzzleHttp\Client;

class DomainsController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function save(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            $urlError = $validator->errors()->first('url');
            $errors = ['url' => $urlError];
            return view('index', ['errors' => $errors]);
        }
        
        $url = $request->get('url');
        try {
            $response = $this->client->get($url);
        } catch (\Exception $e) {
            $errors = ['url' => "Wrong url"];
            return view('index', ['errors' => $errors]);
        }
    
        $body = $response->getBody()->getContents();
        $code = $response->getStatusCode();
        $contentLengthHeader = $response->getHeader('Content-Length')[0] ?? 'no data';

        $document = new Document($body);
        $heading = $document->has('h1') ? $document->find('h1')[0]->text() : 'no data';
        $description = $document->find('meta[name=description]::attr(content)')[0] ?? 'no data';
        $keywords = $document->find('meta[name=keywords]::attr(content)')[0] ?? 'no data';
        
        Domain::create([
            'name' => $url,
            'body' => utf8_encode($body),
            'heading' => $heading,
            'description' => $description,
            'keywords' => $keywords,
            'status_code' => $code,
            'content_length' => (string) $contentLengthHeader,
        ]);
        
        return redirect()->route('domains.show', ['id' => $domains->id]);
    }

    public function show($id)
    {
        $domain = Domain::findOrFail($id);
        return view('domains.list', ['domains' => [$domain]]);
    }

    public function showAll()
    {
        $domains = Domain::paginate(5);
        return view('domains.list', ['domains' => $domains]);
    }
}
