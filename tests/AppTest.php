<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use App\Domain;


class AppTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(route('index'))
            ->assertResponseStatus(200);
    }

    public function initiateMockingHandlers()
    {
        $response_200 = json_encode(["status" => "successful"]);
        $mock = new MockHandler([new Response(200, [], $response_200)]);
        $handler = HandlerStack::create($mock);
        $mockingHandler = new Client(['handler' => $handler]);
        $this->app->instance(Client::class, $mockingHandler);
    }

    public function testSave()
    {
        $url = 'https://www.google.com';
        $this->initiateMockingHandlers();
        $this->post(route('domains.store'), ['url' => $url]);
        $this->seeInDatabase('domains', ['name' => $url]);
    }

    public function testShowAll()
    {
        factory(Domain::class, 10)->create();
        $this->get(route('domains.index'))
            ->assertResponseStatus(200);
    }

    public function testShow()
    {
        factory(Domain::class, 10)->create();
        $this->get(route('domains.show', ['id' => 1]))
            ->assertResponseStatus(200);
    }
}
