<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\BilletType;
use App\Form\CommandeType;
use App\Service\CheckPrice;
use App\Service\PriceHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
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

        $session = $request->getSession();
        return $this->render('ticket/home.html.twig', [
            'title' => 'Bienvenue au Musée du Louvre'
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
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ticket_1(Request $request, EntityManagerInterface $em)
    {
        $commande = new Commande();
        $session = $request->getSession();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);


        if ($request->isMethod('POST')) {
            if ($form->isSubmitted() && $form->isValid()) {
                //  creation de la session commande, on y place l'objet commande contenu dans $order //
                $session->set("commande", $commande);
                //   On met en place la date de creation de la commande (aujourd'hui)
                $commande->setCreatedAt(new \DateTime());
                //  on appelle l'EntityManager

                $em = $this->getDoctrine()->getManager();
                $em->persist($commande);
                $em->flush();
//
                $this->addFlash('success', "Etape suivante : Veuillez renseigner chaque ticket.");
//  on redirect vers la deuxieme phase
                return $this->redirectToRoute('ticket_phase_2');

            } else
                return $this->render('ticket/index.html.twig');
        }

        return $this->render('ticket/index.html.twig', [
            'title' => " Réservation en ligne",
            'formCommande' => $form->createView()
        ]);
    }

    /**
     * @Route("/ticket2", name="ticket_phase_2")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ticket_2(Request $request)
    {

        $billet = new Billet();
        $session = $request->getSession();
        $commande = $session->get("commande");
        $nombre_tickets = $commande->getNbTickets();

        $form = $this->createFormBuilder();
        for ($i = 0; $i < $nombre_tickets; $i++) {
            $form->add($i, BilletType::class, [
                'label' => "VISITEUR N°" . ($i + 1)])
                ->getForm();
        }

        $formBillet = $form->getForm();
        $formBillet->handleRequest($request);
        $form->getData();

        if ($formBillet->isSubmitted() && $formBillet->isValid()) {
            $data = $formBillet->getData();

            for ($i = 0; $i < $nombre_tickets; $i++) {
                $commande->addBillet($data[$i]);

            }
            $session->set('commande', $commande);
//            $em->persist($commande);
//            $em->flush();

            $id = $commande->getId();

            return $this->redirectToRoute('ticket_phase_3', [
                'commande' => $commande
            ]);
        }

        return $this->render('ticket/ticket_phase2.html.twig', [
            'billet' => $billet,
            'title' => 'Choix du billet',
            'formBillet' => $formBillet->createView()
        ]);
    }

    /**
     * @Route("/ticket3", name="ticket_phase_3")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showOrder(Request $request, CheckPrice $checkPrice)
    {
        $session = $request->getSession();
        $commande = $session->get("commande");
        $billet = $session->getId();
        $billet = $checkPrice->generateBillets($commande);


        $mail = $commande->getMail();

        return $this->render('ticket/ticket_phase3.html.twig', [
            'mail' => $mail,
            'commandes' => $commande,
            'billets' => $billet,
        ]);
    }

    /**
     * @Route("/cashout" , name="cashout")
     * @return Response
     */
    public function cashout()
    {

        return $this->render('order/checkout.html.twig', [

        ]);
    }
}