<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 25/08/2018
 * Time: 22:00
 */

namespace App\Service;

use App\Entity\Billet;
use App\Entity\Commande;
use Doctrine\ORM\EntityManager;


class CheckPrice
{

    /**
     * @param Commande $commande
     * @return Billet|mixed
     */
    public function generateBillets(Commande $commande)
    {
        foreach ($commande->getBillets() as $billet)
        {
            $billet->setBillet($this->generateBillet($billet, $commande));
        }

        return $billet;
    }

    /**
     * @param Billet $billet
     * @param Commande $commande
     * @return Billet
     */
    public function generateBillet(Billet $billet, Commande $commande)
    {
        $dateNaissance = $billet->getBirthday();
        $dateVisite = $commande->getDateVisit();
        $diff = $dateNaissance->diff($dateVisite);
        $age = $diff->format('%Y');


        $categorie = 0;
        $tarif = 16;

        if ($age < 4)
        {
            $categorie = 0;
            $tarif = 0;
        } elseif ($age < 12 AND $age > 4)
        {
            $categorie = 1;
            $tarif = 8;
        } elseif ($billet->getDiscount())
        {
            $categorie = 2;
            $tarif = 10;
        } elseif ($age > 60)
        {
            $categorie = 3;
            $tarif = 12;
        } else
            {
            $categorie = 4;
            $tarif = 16;
        }

        if ($commande->getHalfday()) {
            $tarif = $tarif / 2;
        }

        $name = $billet->getName();
        $codeBillet = substr($name, 1, 1);
        $codeBillet .= $categorie;
        $codeBillet .= substr($name, 3, 1);
        $codeBillet .= rand(100, 9999);
        $codeBillet .= substr($name, 2, 1);
        //Set données du billet
        $billet->setCategorie($categorie);
        $billet->setTarif($tarif);
        $billet->setCodeBillet($codeBillet);

        return $billet;
    }
// TODO CALCULER LE MONTANT TOTAL POUR PASSER A STRIPE
    public function totalTarif ($billets)
    {
        {
            $totalTarif = 0;

            foreach ($billets as $billet)
            {
                $totalTarif = $billet->getTarif();
                $coutTotal += $coutTarif;
            }
            return $coutTotal;
        }
    }

}