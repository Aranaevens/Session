<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Stagiaire;

use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TelType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
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
     * @Route("/{id}", name="show_session", methods="GET")
     */
    public function showSession(Session $formation): Response{
        $stagiaires = $this->getDoctrine()
                           ->getRepository(Stagiaire::class)
                           ->stagiairesByFormation($formation->getId());

        $durees = $this->getDoctrine()
                       ->getRepository(Composer::class)
                        ->moduleBySession($formation->getId());                   
        
        return $this->render('formation/show_session.html.twig',[
            'formation' => $formation,
            'stagiaires'=>$stagiaires,
            'durees'=>$durees,
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