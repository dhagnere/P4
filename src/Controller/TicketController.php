<?php

namespace App\Controller;

use App\Entity\Commande;
use Doctrine\Common\Persistence\ObjectManager;
use function Sodium\add;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class TicketController extends Controller
{
    /**
     * @param Request $request
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/" , name="home")
     */
    public function home(Request $request, SessionInterface $session) {

        $session = $request->getSession();
        return $this->render('ticket/home.html.twig' ,[
            'title'=>"Bienvenue sur la billetterie en ligne du Musée du Louvre"
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/mentions" , name="mentions")
     */

    Public function mentions()
    {
        return $this->render('ticket/mentions.html.twig', [
            'title' => "Les mentions légales"
        ]);
    }

    /**
     * @Route("/ticket1", name="ticket_phase_1")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ticket_1(Request $request ,ObjectManager $manager)
    {
        $session = $request->getSession();
        dump($request);
        $commande = new Commande();

        $form = $this->createFormBuilder($commande)
            ->add('mail',EmailType::class, [
                'attr'=>[
                    'placeholder'=>'Votre Email']
            ])
            ->add('date_visit', DateType::class)
            ->add('nb_tickets', IntegerType::class)
            ->add('createdAt', DateType::class)
            ->getForm();

        return $this->render('ticket/index.html.twig', [
            'title'=>" Réservation en ligne",
            'formCommande'=> $form->createView()
        ]);
    }

}
