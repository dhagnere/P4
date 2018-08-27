<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 25/08/2018
 * Time: 22:00
 */

namespace App\Service;


use App\Entity\Commande;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class CheckPrice
{
    public function age(EntityManager $em , $dateOrder , $id)
    {
        $repository = $em->getRepository(Commande::class);
        $dateOrder = $repository->findOneBy(['id'=>$id]);

        if (!$dateOrder) {
            echo(sprintf('Pas de commande avec l\'indentifiant"', $id));
        }
    }

}