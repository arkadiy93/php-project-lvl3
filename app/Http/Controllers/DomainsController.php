<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains;
use DiDom\Document;
use GuzzleHttp\Client;

class DomainsController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function initialize()
    {
        return view('index');
    }

    public function saveDomain(Request $request)
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
        
        $domains = new Domains();
        $domains->name = $url;
        $domains->body = "some text";
        
        $document = new Document($body);
        $domains->heading = $document->has('h1') ? $document->find('h1')[0]->text() : 'no data';
        $domains->description = $document->find('meta[name=description]::attr(content)')[0] ?? 'no data';
        $domains->keywords = $document->find('meta[name=keywords]::attr(content)')[0] ?? 'no data';
        
        $domains->status_code = $code;
        $domains->content_length = $contentLengthHeader;
        $domains->save();
    
        $id = $domains->id;
        return redirect()->route('domains.show', ['id' => $id]);
    }

    public function showDomain($id)
    {
        $domain = Domains::find($id);
        return view('list', ['domains' => [$domain]]);
    }

    public function getDomainList()
    {
        $domains = Domains::paginate(5);
        return view('list', ['domains' => $domains]);
    }
}
