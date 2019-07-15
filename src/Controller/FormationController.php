<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Route("/formations")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="listAllFormations")
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
     * @Route("/formation/{id}}", name="showOneFormation", methods="GET")
     */
    public function show(Session $session): Response{
        return $this->render('formation/show.html.twig',['session'=>$session]);
    }
    /**
     * @Route("/categorie", name="listAllCategories")
     */
    public function listCategories(){
        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->getAll();

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
    /**
     * @Route("/modul", name="listAllModules")
     */
    public function listModules(){
        $modules = $this->getDoctrine()
                        ->getRepository(Modul::class)
                        ->findAll();
    }

    




}