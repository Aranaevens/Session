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
    public function listFormateurs()
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
    public function showFormateurs(Formateur $formateur)
    {
        return $this->render('personnes/form_show.html.twig', [
            'formateur' => $formateur,
        ]);
    }

    /**
     * @Route("/stagiaires", name="stagiaires_list")
     */
    public function listStagiaire()
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
    public function showStagiaire(Stagiaire $stagiaire)
    {
        return $this->render('personnes/form_list.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }
}
