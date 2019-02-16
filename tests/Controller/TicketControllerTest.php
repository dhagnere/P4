<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 30/01/2019
 * Time: 15:39
 */

namespace App\tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;



class TicketControllerTest extends WebTestCase
{
    public function testIndex()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue au Musée du Louvre', $crawler->filter('.container h1')->text());
    }

}

