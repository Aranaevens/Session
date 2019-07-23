<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Stagiaire;

use App\Form\FormateurType;

use App\Form\StagiaireType;
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
 * @Route("/personnes")
 */
class PersonnesController extends AbstractController
{
    /**
     * @Route("/{id}/calendar", name="formateur_calendar", methods={"GET"})
     */
    public function calendar(Formateur $formateur): Response
    {
        return $this->render('personnes/calendar.html.twig', [
            'formateur' => $formateur,
        ]);
    }
    
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
     * @Route("/formateurs/{id}/delete", name="formateur_delete")
     */
    public function deleteFormateur(Formateur $formateur, ObjectManager $manager): Response
    {
        $manager->remove($formateur);
        $manager->flush();
        
        return $this->redirectToRoute('formateurs_list');
    }

    /**
     * @Route("/formateurs/add", name="formateur_add")
     * @Route("/formateurs/{id}/edit", name="formateur_edit")
     */
    public function addFormateur(Formateur $formateur = null, Request $request, ObjectManager $manager)
    {
        if (!$formateur)
        {
            $formateur = new Formateur();
        }

        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($formateur);
            $manager->flush();

            return $this->redirectToRoute('formateurs_list');
        }

        return $this->render('personnes/add_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/formateurs", name="formateurs_list")
     */
    public function listFormateur(): Response
    {
        $formateurs = $this->getDoctrine()
                            ->getRepository(Formateur::class)
                            ->findAll();

        return $this->render('personnes/form_list.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    /**
     * @Route("/formateurs/{id}", name="formateur_show")
     */
    public function showFormateur(Formateur $formateur): Response
    {
        $sessions = $this->getDoctrine()
                            ->getRepository(Session::class)
                            ->findByFormateur($formateur->getId());

        $categories = $this->getDoctrine()
                            ->getRepository(Categorie::class)
                            ->findByFormateur($formateur->getId());
        
        return $this->render('personnes/form_show.html.twig', [
            'formateur' => $formateur,
            'sessions' => $sessions,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/stagiaires/{id}/delete", name="stagiaire_delete")
     */
    public function deleteStagiaire(Stagiaire $stagiaire, ObjectManager $manager): Response
    {
        $manager->remove($stagiaire);
        $manager->flush();
        
        return $this->redirectToRoute('stagiaires_list');
    }

    /**
     * @Route("/stagiaires/add", name="stagiaire_add")
     * @Route("/stagiaires/{id}/edit", name="stagiaire_edit")
     */
    public function addStagiaire(Stagiaire $stagiaire = null, Request $request, ObjectManager $manager)
    {
        if (!$stagiaire)
        {
            $stagiaire = new Stagiaire();
        }

        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($stagiaire);
            $manager->flush();

            return $this->redirectToRoute('stagiaires_list');
        }

        return $this->render('personnes/add_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/stagiaires/{id}", name="stagiaire_show")
     */
    public function showStagiaire(Stagiaire $stagiaire): Response
    {
        $sessions = $this->getDoctrine()
                            ->getRepository(Session::class)
                            ->findByStagiaire($stagiaire->getId());
        
        return $this->render('personnes/stag_show.html.twig', [
            'stagiaire' => $stagiaire,
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/stagiaires", name="stagiaires_list")
     */
    public function listStagiaire(): Response
    {
        $stagiaires = $this->getDoctrine()
                            ->getRepository(Stagiaire::class)
                            ->findAll();

        return $this->render('personnes/stag_list.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }
}
