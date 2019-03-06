<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 06/03/2019
 * Time: 18:38
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/reservation_impossible'];
        yield ['/mentions'];
        yield ['/ticket1'];
    }
}