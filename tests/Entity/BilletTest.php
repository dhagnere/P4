<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 18/02/2019
 * Time: 23:56
 */

namespace App\Tests\Entity;


use App\Entity\Billet;
use PHPUnit\Framework\TestCase;


class BilletTest extends TestCase
{
    public function testBillet()
    {
        $billet = new Billet();
        $billet
            ->setName('Hagnere')
            ->setSurname('David')
            ->setDiscount('1')
            ->setCodeBillet('abcd1234');
        $this->assertEquals('Hagnere', $billet->getName());
        $this->assertEquals('David', $billet->getSurname());
        $this->assertEquals('1', $billet->getDiscount());
        $this->assertEquals('abcd1234', $billet->getCodeBillet());
    }
}