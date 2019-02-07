<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\BilletType;
use App\Form\CommandeType;
use App\Service\CheckNbTicket;
use App\Service\CheckPrice;
Use App\Service\Email;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class TicketController extends AbstractController
{

    /**
     * @param Request $request
     * @param SessionInterface $session
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/" , name="home")
     */
    public function home(Request $request, SessionInterface $session)
    {

        $session = $request->getSession ();
        return $this->render ('ticket/home.html.twig', [
            'title' => 'Bienvenue au Musée du Louvre'
        ]);
    }

    /**
     * @Route("/reservation_impossible" , name="reservation_impossible")
     */
    public function reservation_impossible(Request $request, EntityManagerInterface $em, CheckPrice $checkPrice)
    {
        return $this->render ('messages/reservation_impossible.html.twig', [

        ]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/mentions" , name="mentions")
     */

    Public function mentions()
    {
        return $this->render ('ticket/mentions.html.twig', [
            'title' => "Les mentions légales"
        ]);
    }

    /**
     * @Route("/ticket1", name="ticket_phase_1")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ticket_1(Request $request, EntityManagerInterface $em)
    {

        $commande = new Commande();
        $session = $request->getSession ();
        $form = $this->createForm (CommandeType::class, $commande);
        $form->handleRequest ($request);


        if ($request->isMethod ('POST')) {
            if ($form->isSubmitted () && $form->isValid ()) {
                $session->set ("commande", $commande);
                $commande->setCreatedAt (new \DateTime());
                $visit = $commande->getDateVisit ();

                $em->persist ($commande);

                $repository = $em->getRepository (Commande::class);
                    $nb_tickets_on_day = $repository->getNbVisitors($visit);

                        if ($nb_tickets_on_day>1000)
                            {
                                $this->addFlash ("warning", "impossible pour cette date,le nombre de reservation possible est déja atteint. Veuillez retourner à l'accueil afin de reprendre votre commande, par avance merci !");
                                return $this->redirectToRoute ('reservation_impossible');
                            }
                        else
                            {
                            $this->addFlash ('success', "Etape suivante : Veuillez renseigner chaque ticket.");

                            return $this->redirectToRoute ('ticket_phase_2');
                            }
            } else
                return $this->render ('ticket/index.html.twig' , [
                    'title' => " Réservation en ligne",
                    'formCommande' => $form->createView ()
                ]);
        }

        return $this->render ('ticket/index.html.twig', [
            'title' => " Réservation en ligne",
            'formCommande' => $form->createView ()
        ]);
    }



    /**
     * @Route("/ticket2", name="ticket_phase_2")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ticket_2(Request $request, EntityManagerInterface $em, CheckPrice $checkPrice)
    {

        $billet = new Billet();
        $session = $request->getSession ();
        $commande = $session->get ("commande");
        $nombre_tickets = $commande->getNbTickets ();

        $form = $this->createFormBuilder ();
        for ($i = 0; $i < $nombre_tickets; $i++) {
            $form->add ($i, BilletType::class, [
                'label' => "VISITEUR N°" . ($i + 1)])
                ->getForm ();
        }

        $formBillet = $form->getForm ();
        $formBillet->handleRequest ($request);
        $form->getData ();

        if ($request->isMethod ('POST')) {
            if ($formBillet->isSubmitted () && $formBillet->isValid ()) {
                $data = $formBillet->getData ();

                for ($i = 0; $i < $nombre_tickets; $i++) {
                    $commande->addBillet ($data[$i]);
                }

                return $this->redirectToRoute ('ticket_phase_3', [
                    'commande' => $commande
                ]);
            }
        }

        return $this->render ('ticket/ticket_phase2.html.twig', [
            'billet' => $billet,
            'title' => 'Choix du billet',
            'formBillet' => $formBillet->createView ()
        ]);
    }

    /**
     * @Route("/ticket3", name="ticket_phase_3")
     * @param Request $request
     * @param CheckPrice $checkPrice
     * @param EntityManagerInterface $em
     * @param Email $email
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */

    public function showOrder(Request $request, CheckPrice $checkPrice, EntityManagerInterface $em, Email $email)
    {
        $session = $request->getSession ();
        $commande = $session->get ("commande");
        $billet = $session->getId ();
        $billet = $checkPrice->generateBillets ($commande);
        $mail = $commande->getMail ();

        $session->set ('commande', $commande);
        $em->persist ($commande);
        $em->flush ();

        if ($request->isMethod ('POST')) {
            $token = $request->get ('stripeToken');
            try {
                \Stripe\Stripe::setApiKey ($this->getParameter ('stripe_secret_key'));
                \Stripe\Charge::create (array(
                    "amount" => $commande->getPrixTotal () * 100,
                    "currency" => "eur",
                    "source" => "$token",
                    "description" => "test premiere facturation"
                ));
            }catch (\Stripe\Error\Card $e)
            {
                $$this->addFlash ('refus', 'Votre paiement à été refusé veuillez saisir un autre numéro de carte');

                return $this->render ('ticket/ticket_phase3.html.twig',
                    array('commande' => $commande,
                        'stripe_public_key' => $this->getParameter ('stripe_public_key')));
            }

            $email->sendMail ($commande);
            $this->addFlash ('Success', 'Votre commande est bien enregistrée');


            return $this->redirectToRoute ('Merci');

        }

        return $this->render ('ticket/ticket_phase3.html.twig', [
            'mail' => $mail,
            'commande' => $commande,
            'billets' => $billet,
            'stripe_public_key' => $this->getParameter ('stripe_public_key')
        ]);
    }

    /**
     * @Route("/thanks", name="Merci"))
     *
     */
    public function thanks(Request $request, \Swift_Mailer $mailer)
    {
        $session = $request->getSession ();
        $commande = $session->get ("commande");
        $mail = $commande->getMail ();




        return $this->render ('remerciements/thanks.html.twig', [
            'title' => 'Merci pour votre future visite'
        ]);
    }
}