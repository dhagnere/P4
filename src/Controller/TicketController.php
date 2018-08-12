<?php

namespace App\Controller;

use App\Entity\Billet;
use App\Entity\Commande;
use App\Form\BilletType;
use App\Form\CommandeType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Form\FormBuilderInterface;


class TicketController extends AbstractController
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
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ticket_1(Request $request ,ObjectManager $manager, EntityManagerInterface $em)
    {
        $commande = new Commande();
        $session = $request->getSession();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($request->isMethod('POST'))
        {
            if($form->isSubmitted() && $form->isValid())
            {
                //  creation de la session order, on y place l'objet order contenu dans $order //
                $session->set("commande" , $commande);
                //  on appelle l'EntityManager

                $em=$this->getDoctrine()->getManager();
                $em->persist($commande);
                $em->flush();

                $this->addFlash('success' , "Etape suivante : Veuillez renseigner chaque ticket.");
                //  on redirect vers la deuxieme phase
                return $this->redirectToRoute('ticket_phase_2');

            }
            else
                return $this->render('ticket/index.html.twig');
        }

        return $this->render('ticket/index.html.twig', [
            'title'=>" Réservation en ligne",
            'formCommande'=> $form->createView()
        ]);
    }

    /**
     * @Route("/ticket2", name="ticket_phase_2")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ticket_2(Request $request)
    {

    $billet =   new billet;
    $session=$request->getSession();
    $commande = $session->get("commande");

    $nombre_tickets = $commande->getNbTickets();


        $form=$this->createFormBuilder();

        //      creation d'une boucle pour afficher le nombre de billets récupéré dans la commande(formCommande)
            for ($i=0; $i<$nombre_tickets; $i++)
            {
                $form->add($i, BilletType::class, [
                    'label'=>"VISITEUR N°".($i+1)
            ]);
        //TODO CREER LE SUBMIT
        }

        $formBillet=$form->getForm();
            return $this->render('ticket/ticket_phase2.html.twig', [
                'billet'=>$billet,
                'title'=>'Choix du billet',
                'formBillet'=>$formBillet->createView()
            ]);
        }


}
