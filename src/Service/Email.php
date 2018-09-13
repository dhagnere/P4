<?php
/**
 * Created by PhpStorm.
 * User: drcha
 * Date: 09/09/2018
 * Time: 23:40
 */

namespace App\Service;


use App\Entity\Commande;


class Email

{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer , \Twig_Environment $twig )
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendMail(Commande $commande)

    {

        $message = (new\Swift_Message('Mail de confirmation'))
            ->setFrom('jobwow@gmail.com')
            ->setTo($commande->getMail())
            ->setBody(
                $this->twig->render('remerciements/email.html.twig',
                    array(
                   'commande' => $commande)))
            ->setContentType('text/html');


        $this->mailer->send($message);
    }


}