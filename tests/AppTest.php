<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AppTest extends TestCase
{
    use DatabaseTransactions;
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
