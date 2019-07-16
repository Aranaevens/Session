<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Entity\Stagiaire;
use App\Entity\Categorie;
use App\Entity\Composer;
use App\Entity\Modul;
use App\Entity\Session;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;


/**
 * @Route("/personnes")
 */
class PersonnesController extends AbstractController
{
    /**
     * @Route("/{id}/formateurs/", name="formateurs_session", methods="GET")
     */
    public function showFormateursBySession(Session $session): Response
    {
        $formateurs = $this->getDoctrine()
                            ->getRepository(Formateur::class)
                            ->findbySession($session->getId());
        
        return $this->render('personnes/form_show_session.html.twig', [
            'formateurs' => $formateurs,
            'session' => $session,
        ]);
    }

    /**
     * @Route("/", name="personnes_index")
     */
    public function index()
    {
        return $this->render('personnes/index.html.twig', [
            'controller_name' => 'PersonnesController',
        ]);
    }
    
    /**
     * @Route("/formateurs", name="formateurs_list")
     */
    public function listFormateurs(): Response
    {
        $formateurs = $this->getDoctrine()
                            ->getRepository(Formateur::class)
                            ->findAll();

        return $this->render('personnes/form_list.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    /**
     * @Route("/formateurs/{id}", name="formateurs_show")
     */
    public function showFormateurs(Formateur $formateur): Response
    {
        $sessions = $this->getDoctrine()
                            ->getRepository(Session::class)
                            ->findByFormateur($formateur->getId());
        
        return $this->render('personnes/form_show.html.twig', [
            'formateur' => $formateur,
            'sessions' => $sessions,
        ]);
    }

    

    /**
     * @Route("/stagiaires", name="stagiaires_list")
     */
    public function listStagiaire(): Response
    {
        $stagiaires = $this->getDoctrine()
                            ->getRepository(Formateur::class)
                            ->findAll();

        return $this->render('personnes/form_list.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
     * @Route("/stagiaires/{id}", name="stagiaires_show")
     */
    public function showStagiaire(Stagiaire $stagiaire): Response
    {
        return $this->render('personnes/form_list.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }
}
