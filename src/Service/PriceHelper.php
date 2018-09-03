<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 02/09/2018
 * Time: 17:27
 */

namespace App\Service;


use App\Entity\Billet;
use App\Entity\Commande;

class PriceHelper
{

    public function generateBillets (Commande $commande, Billet $billet)
    {
        foreach ($commande->getBillets() as $billet)
        {
            $billet->setBillet($this->generateBillets( $commande, $billet));
        }
        return $billet;
    }

}