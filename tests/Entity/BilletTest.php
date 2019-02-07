<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 07/02/2019
 * Time: 15:18
 */

namespace App\Tests\Entity;


use App\Entity\Billet;
use PHPUnit\Framework\TestCase;

class BilletTest extends TestCase
{
    /**
     *
     */
    public function testBillet()
    {
        $billet = new Billet();
        $billet ->setName ('testname')
                ->setSurname ('testsurname')
                ->setDiscount ('1')
                ->setCodeBillet ('abcd12345');
        $this ->assertEquals ('testname' , $billet->getName ());
        $this ->assertEquals ('testsurname' , $billet->getSurname ());
        $this ->assertEquals ('1' , $billet->getDiscount ());
        $this ->assertEquals ('abcd12345' , $billet->getCodeBillet ());
    }
}