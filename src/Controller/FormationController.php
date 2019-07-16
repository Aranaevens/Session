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
     * @Route("/formation/{id}}", name="showOneFormation", methods="GET")
     */
    public function show(Session $session): Response{
        return $this->render('formation/show.html.twig',['session'=>$session]);
    }
    /**
     * @Route("/stagiaire/{id}", name="showStagiairesByFormation", methods="GET")
     */
    public function showStagiairesByFormation(Session $formation){
        $stagiaires = $this->getDoctrine()
                           ->getRepository(Stagiaire::class)
                           ->StagiairesByFormation($formation->getId());
        return $this->render('formation/showStagiairesByFormation.html.twig',[
            'stagiaires'=>$stagiaires,
        ]);
        
    }
    /**
     * @Route("/categorie", name="listAllCategories")
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
     * @Route("/categorie/{id}}", name="voirOneCategorie", methods="GET")
     */
    public function voirCategorie(Categorie $categorie): Response{
        return $this->render('formation/voirCategorie.html.twig',['categorie'=>$categorie,
        ]);
    }

}