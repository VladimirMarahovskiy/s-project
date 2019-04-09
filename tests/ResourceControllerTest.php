<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResourceControllerTest extends WebTestCase
{
    public function testShowPage()
    {
        $client = static::createClient();

        $client->request('GET', 'http://s-project.loc/');
       // $client->request('GET', 'http://s-project.loc/test');
    //    $client->request('GET', 'http://s-project.loc/page5');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}
