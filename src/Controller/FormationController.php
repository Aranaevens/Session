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
     * @Route("/modules", name="modules_list")
     */
    public function listModules(): Response
    {
        $modules = $this->getDoctrine()
                         ->getRepository(Modul::class)
                         ->findAll();

        return $this->render('formation/modules_list.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/modules/{id}", name="module_show")
     */
    public function showModule(Modul $module): Response
    {
        $sessions = $this->getDoctrine()
                         ->getRepository(Session::class)
                         ->findByModule($module->getId());

        return $this->render('formation/modules_show.html.twig', [
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
     * @Route("/", name="formations_list")
     */
    public function listFormations(): Response{
        $sessions = $this->getDoctrine()
                         ->getRepository(Session::class)
                         ->findAll();

        return $this->render('formation/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @Route("/formations/{id}", name="session_delete")
     */
    public function deleteSession(Session $session, ObjectManager $manager) : Response {
        $manager->remove($session);
        $manager->flush();

        return $this->redirectToRoute('formations_list');
    }

    /**
     * @Route("/modules/{id}", name="module_delete")
     */
    public function deleteModule(Modul $module, ObjectManager $manager) : Response {
        $manager->remove($module);
        $manager->flush();

        return $this->redirectToRoute('modules_list');
    }

}