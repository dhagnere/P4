<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 07/02/2019
 * Time: 15:18
 */

namespace App\tests\Entity;

use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class CommandeTest extends TestCase
{
    /**
     *
     */
    public function testCommande()
    {
        $commande = new Commande();

        $commande
            ->setMail('d.r.c.hagnere@gmail.com')
            ->setDateVisit( \DateTime::createFromFormat('d/m/Y','28/12/2019'))
            ->setNbTickets(3)
            ->setHalfday (0);

        $this->assertEquals('d.r.c.hagnere@gmail.com', $commande->getmail());
        $this->assertEquals('28/12/2019', $commande->getDateVisit()->format('d/m/Y'));
        $this->assertEquals(3, $commande->getNbTickets());
        $this->assertEquals(0, $commande->getHalfday());
    }
}