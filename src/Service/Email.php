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

    /**
     * @param Commande $commande
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMail(Commande $commande)

    {
        $image = ('images/louvre.jpg');

        $message = new\Swift_Message('Mail de confirmation');
        $logo = $message->embed(\Swift_Image::fromPath($image));
        $message
            ->setFrom('jobwow@gmail.com')
            ->setTo($commande->getMail())
            ->setBody(
                $this->twig->render('remerciements/email.html.twig',
                    array(
                   'logo'=> $logo,
                   'commande' => $commande)))
            ->setContentType('text/html');

        $this->mailer->send($message);
    }
}