<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 09/09/2018
 * Time: 23:40
 */

namespace App\Service;

use App\Entity\Billet;
use App\Entity\Commande;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;

class Cart

{

    private $session;
    private $em;

    private $PrixTotal;

    public function __construct(Session $session, EntityManager $em)
    {
        $this->session = $session;
        $this->em = $em;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->getTotal() as $total) {
            $total += $total->getPrice();
        }

        return $total;
    }
}