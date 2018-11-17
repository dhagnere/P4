<?php

namespace App\Service;


use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;


class CheckNbTicket

{
    public function getTotalTicket(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Commande::class);
        $ticketCount = $repository->findOneBy(array('nb_tickets'));

       return($ticketCount);
    }


}