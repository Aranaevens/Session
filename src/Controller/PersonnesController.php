<?php

namespace App\Controller;

// require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

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
     * @Route("/formateurs/delete/{id}", name="formateur_delete")
     */
    public function deleteFormateur(Formateur $formateur, ObjectManager $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $manager->remove($formateur);
        $manager->flush();
        
        return $this->redirectToRoute('formateurs_list');
    }

    /**
     * @Route("/formateurs/add", name="formateur_add")
     * @Route("/formateurs/edit/{id}", name="formateur_edit")
     */
    public function addFormateur(Formateur $formateur = null, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
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
     * @Route("/formateurs/", name="formateurs_list")
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
     * @Route("/stagiaires/delete/{id}", name="stagiaire_delete")
     */
    public function deleteStagiaire(Stagiaire $stagiaire, ObjectManager $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $manager->remove($stagiaire);
        $manager->flush();
        
        return $this->redirectToRoute('stagiaires_list');
    }

    /**
     * @Route("/stagiaires/add", name="stagiaire_add")
     * @Route("/stagiaires/edit/{id}", name="stagiaire_edit")
     */
    public function addStagiaire(Stagiaire $stagiaire = null, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
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

    /**
     * @Route("/diplome/{id}/{id_formation}", name="diplome")
     * @Entity("formation", expr="repository.find(id_formation)")
     */
    public function getDiplome(Stagiaire $stagiaire, Session $formation): Reponse
    {
        $auj = new \DateTime();
        $today = $auj->format('d/m/Y');
        $html2pdf = new Html2Pdf('L', 'A4', 'fr');
        $html2pdf->writeHTML('<style>h1 {
            text-align: center;
            margin-top: 15%;
        }
        
        #main {
            text-align: justify;
            width: 60%;
            margin: 10% 20% 0.5em 20%;
        }
        
        #right {
            width: 60%;
            margin: 0.5em 20% 0.5em 20%;
            text-align: right;
        }</style>');
        $html2pdf->writeHTML('<h1>Diplôme</h1>');
        if ($stagiaire->getGenre() == 'M')
        {
            $html2pdf->writeHTML('<div id="main"><p>Elan Formation stipule que le stagiaire ' . $stagiaire->getPrenom() . " " . $stagiaire->getNom() . ' a bien effectué la formation professionnelle <strong>' . $formation->getIntitule() . '</strong> au sein de notre établissement</p></div>');
        }
        else
        {
            $html2pdf->writeHTML('<div id="main"><p>Elan Formation stipule que la stagiaire ' . $stagiaire->getPrenom() . " " . $stagiaire->getNom() . ' a bien effectué la formation professionnelle <strong>' . $formation->getIntitule() . '</strong> au sein de notre établissement</p></div>');
        }
        // $html2pdf->writeHTML('a bien effectué la formation professionnelle <strong>' . $formation->getIntitule() . '</strong> au sein de notre établissement</p></div>');
        $html2pdf->writeHTML('<div id="right">Fait le ' . $today . '</div>');
        $html2pdf->output("diplome_" . $stagiaire->getPrenom() . "_" . $stagiaire->getNom() . ".pdf");

        return $this->redirectToRoute('show_session', [
            'id' => $formation->getId(),
        ]);
    }
}
