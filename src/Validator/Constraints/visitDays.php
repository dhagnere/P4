<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 26/01/2019
 * Time: 20:11
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class visitDays
 * @package App\Validator\Constraints
 * @Annotation
 */

class visitDays extends Constraint
{
    public $message = "La date sélectionnée est passée, veuillez sélectionner une date valide.";
    public $message2 = "désolé, nous sommes fermé les dimanches et mardis";
    public $message3= "désolé nous serons fermé à cette date";
    public $message4 = "Il est plus de 14h, veuillez séléctionner un billet demi-journée";
    public $message5 = "Le musée est complet à cette date";

    public function validatedBy()
    {
        return get_class ($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}