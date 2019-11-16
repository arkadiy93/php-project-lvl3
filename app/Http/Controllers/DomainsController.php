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

    public function store(Request $request)
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
        $contentLengthContent = $response->getHeader('Content-Length');

        $document = new Document($body);
        
        $headingContent = $document->find('h1');
        $descriptionContent = $document->find('meta[name=description]::attr(content)');
        $keywordsContent = $document->find('meta[name=keywords]::attr(content)');

        $contentLengthHeader = $this->extractContent($contentLengthContent);
        $headingData = $this->extractContent($headingContent);
        $heading = $headingData ? $headingData->text() : null;
        $description = $this->extractContent($descriptionContent);
        $keywords = $this->extractContent($keywordsContent);

        $domain = Domain::create([
            'name' => $url,
            'body' => utf8_encode($body),
            'heading' => $heading,
            'description' => $description,
            'keywords' => $keywords,
            'status_code' => $code,
            'content_length' => (string) $contentLengthHeader,
        ]);
        
        return redirect()->route('domains.show', ['id' => $domain->id]);
    }

    public function show($id)
    {
        $domain = Domain::findOrFail($id);
        return view('domains.show', ['domain' => $domain]);
    }

    public function index()
    {
        $domains = Domain::paginate(5);
        return view('domains.index', ['domains' => $domains]);
    }

    private function extractContent($content)
    {
        if (empty($content)) {
            return null;
        }
        return $content[0];
    }
}
