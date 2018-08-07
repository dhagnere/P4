<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TicketController extends Controller
{
    /**
     * @Route("/ticket", name="ticket")
     */
    public function index()
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
            'title'=>" Réservation en ligne"
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/" , name="home")
     */
    public function home() {
        return $this->render('ticket/home.html.twig' ,[
            'title'=>"Bienvenue sur la billetterie en ligne du Musée du Louvre"
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/mentions" , name="mentions")
     */

    Public function mentions(){
        return $this->render('ticket/mentions.html.twig' ,[
            'title'=>"Les mentions légales"
        ]);


    }
}
