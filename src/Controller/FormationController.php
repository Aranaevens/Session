<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Categorie;
use App\Entity\Stagiaire;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/formations")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="listAllFormations")
     */
    public function index(){
        $sessions = $this->getDoctrine()
                         ->getRepository(Session::class)
                         ->findAll();

        return $this->render('formation/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
     /**
     * @Route("formation/{id}", name="show_session", methods="GET")
     */
    public function showSession(Session $session): Response{
        return $this->render('formation/show_session.html.twig',['session'=>$session]);
    }
    /**
     * @Route("stagiaire/{id}", name="stagiaires_formation", methods="GET")
     */
    public function stagiairesByFormation(Session $formation){
        $stagiaires = $this->getDoctrine()
                           ->getRepository(Stagiaire::class)
                           ->stagiairesByFormation($formation->getId());
        return $this->render('formation/stagiaires_formation.html.twig',[
            'stagiaires'=>$stagiaires,
        ]);
        
    }
    /**
     * @Route("/categorie", name="Categories_list")
     */
    public function listCategories(){
        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->findAll();

        return $this->render('formation/listCategories.html.twig',[ 
            'categories'=>$categories,
        ]);
    }
    /**
     * @Route("categorie/{id}}", name="Categorie_voir", methods="GET")
     */
    public function voirCategorie(Categorie $categorie): Response{
        return $this->render('formation/voirCategorie.html.twig',['categorie'=>$categorie,
        ]);
    }

}