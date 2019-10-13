<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use App\Http\Controllers\DomainsController;


class AppTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp() :void
    {
        parent::setUp();
        $this->app->bind(DomainsController::class, function () {
            $response_200 = json_encode(array("status" => "successful"));
        
            $mock = new MockHandler([new Response(200, [], $response_200)]);
        
            $handler = HandlerStack::create($mock);
        
            return new DomainsController(new \GuzzleHttp\Client(['handler' => $handler]));
        });
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexConnection()
    {
        $this->get(route('index'))
            ->assertResponseStatus(200);
    }

    public function testDomainsConnection()
    {
        $this->get(route('domains.index'))
            ->assertResponseStatus(200);
    }

    public function testDatabase()
    {
        $url = 'https://www.google.com';
        $this->call('POST', route('domains.store'), ['url' => $url]);
        $this->seeInDatabase('domains', ['name' => $url]);
    }
}
