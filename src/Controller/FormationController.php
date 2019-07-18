<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Stagiaire;

use App\Form\SessionType;

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
        $durees = $this->getDoctrine()
                         ->getRepository(Composer::class)
                         ->findByModule($module->getId());

        return $this->render('formation/modules_show.html.twig', [
            'durees' => $durees,
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

     /**
     * @Route("/sessions/add", name="session_add")
     */
    public function addSession(Request $request, ObjectManager $manager)
    {
            $session = new Session();
        
        $form = $this->createForm(SessionType::class, $session);           
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('formations_list');
        }

        return $this->render('formation/add_session.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/sessions/edit/{id}", name="session_edit")
     */
    public function editSession(Session $session, Request $request, ObjectManager $manager)
    {
        
        $form = $this->createForm(SessionType::class, $session);           
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('formations_list');
        }

        return $this->render('formation/edit_session.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}