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


class CheckPrice
{

    public function generateBillets(Commande $commande)
    {
        foreach ($commande->getBillets() as $billet){
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
        dump($dateNaissance);
        $dateVisite = $commande->getDateVisit();
        dump($dateVisite);

        $diff = $dateNaissance->diff($dateVisite);
        dump($diff);
        $age = $diff->format('%Y');
        dump($age);

        $categorie = 0;
        $tarif = 16;

        if ($age < 4) {
            $categorie = 0;
            $tarif = 0;
        } elseif ($age < 12 AND $age > 4) {
            $categorie = 1;
            $tarif = 8;
        } elseif ($billet->getDiscount()) {
            $categorie = 2;
            $tarif = 10;
        } elseif ($age > 60) {
            $categorie = 3;
            $tarif = 12;
        } else {
            $categorie = 4;
            $tarif = 16;
        }
        dump($tarif);

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
        dump($codeBillet);
        return $billet;
    }

}