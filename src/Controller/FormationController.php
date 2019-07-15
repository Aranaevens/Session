<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="list_formation")
     */
    public function index(){
        $sessions = $this->getDoctrine()
                         ->getRepository(Session::class)
                         ->getAll();

        return $this->render('formation/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
     /**
     * @Route("/{id}}", name="show_formation", method="GET")
     */
    public function show(Session $session): Response{
        return $this->render('formation/show.html.twig',['session'=>$session]);
    }


}
