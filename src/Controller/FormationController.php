<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\Form\ModuleType;
use App\Entity\Categorie;
use App\Entity\Formateur;

use App\Entity\Stagiaire;

use App\Form\SessionType;
use App\Form\ModuleSessionType;

use App\Form\StagiaireSessionType;
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
     * @Route("/{id}/addModule", name="session_add_module")
     */
    public function addModule(Session $session, Request $request, ObjectManager $manager) : Response
    {
        $form = $this->createForm(ModuleSessionType::class);
        $flag = true;
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid() && $flag)
        {
            $duree = new Composer();
            $duree->setSession($session)
                    ->setModule($form->get('module')->getData())
                    ->setNbJours($form->get('nbjours')->getData());
            $manager->persist($duree);
            $manager->flush();

            $flag = false;

            $nextAction = $form->get('back')->isClicked() ? 'show_session' : 'session_add_module';
            return $this->redirectToRoute($nextAction, [
                'id' => $session->getId()
            ]);
        }

        return $this->render('formation/add_module.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addStagiaire", name="session_add_stagiaire")
     */
    public function addStagiaire(Session $session, Request $request, ObjectManager $manager) : Response
    {
        if (($session->getNbPlaces() - count($session->getStagiaires())) == 0)
        {
            $this->addFlash(
                'notice',
                'Il n\'y a plus de place dans cette formation !'
            );
            return $this->redirectToRoute('show_session', [
                'id' => $session->getId()
            ]);
        }
        
        $form = $this->createForm(StagiaireSessionType::class);
        $flag = true;
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid() && $flag)
        {
            $session->addStagiaire($form->get('stagiaire')->getData());
            $manager->flush();

            $flag = false;

            $nextAction = $form->get('back')->isClicked() ? 'show_session' : 'session_add_stagiaire';
            return $this->redirectToRoute($nextAction, [
                'id' => $session->getId()
            ]);

            // return $this->redirectToRoute('show_session', [
            //     'id' => $session->getId()
            // ]);
        }

        return $this->render('formation/add_stagiaire.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{id_stagiaire}/remove", name="session_remove_stagiaire")
     * @Entity("stagiaire", expr="repository.find(id_stagiaire)")
     */
    public function removeStagiaire(Session $session, Stagiaire $stagiaire, Request $request, ObjectManager $manager) : Response
    {
        $session->removeStagiaire($stagiaire);
        $manager->flush();
        
        return $this->showSession($session);
    }

    /**
     * @Route("{id}/delete/", name="session_delete")
     */
    public function deleteSession(Session $session, ObjectManager $manager) : Response {
        $manager->remove($session);
        $manager->flush();

        return $this->redirectToRoute('formations_list');
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
    /**
     * @Route("/modules/edit/{id}", name="module_edit")
     */
    public function editModule(Modul $module, Request $request, ObjectManager $manager)
    {
        
        $form = $this->createForm(ModuleType::class, $module);           
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($module);
            $manager->flush();

            return $this->redirectToRoute('modules_list');
        }

        return $this->render('formation/edit_module.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}