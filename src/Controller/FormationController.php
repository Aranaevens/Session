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
use App\Form\ComposerType;

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("/formations")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/calendar", name="session_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('formation/calendar.html.twig');
    }

     /**
     * @Route("/add", name="session_add")
     * @Route("/edit/{id}", name="session_edit")
     * @IsGranted("ROLE_USER")
     */
    public function addSession(Session $session = null, Request $request, ObjectManager $manager)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        if(!$session)
        {
            $session = new Session();
        }
        $request->getSession()->set('referer', $request->headers->get('referer'));
        $form = $this->createForm(SessionType::class, $session);           
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {
            if ($form->get('dateDebut')->getData() < $form->get('dateDebut')->getData())
            {
                $this->addFlash(
                    'notice',
                    'La date de fin doit être après la date de début'
                );
                return $this->redirect($session->get('referer'));
            }
            
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('formations_list');
        }

        return $this->render('formation/add_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}", name="show_session", methods="GET")
     */
    public function showSession(Session $formation): Response
    {
        
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
            'now' => new \DateTime,
        ]);   
    }

    /**
     * @Route("/addModule/{id}", name="session_add_module")
     * @IsGranted("ROLE_USER")
     */
    public function addModule(Session $session, Request $request, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
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
     * @Route("/edit_module/{id}", name="session_edit_module")
     * @IsGranted("ROLE_USER")
     */
    public function editModule(Composer $duree, Request $request, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $form = $this->createForm(ComposerType::class,$duree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
        
            $manager->persist($duree);
            $manager->flush();

            return $this->redirectToRoute('show_session',['id'=>$duree->getSession()->getId()]);

        }
        return $this->render('formation/edit_module.html.twig', [
            'session' => $duree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/remove_module/{id}/{id_composer}", name="session_remove_module")
     * @Entity("composer", expr="repository.find(id_composer)")
     * @IsGranted("ROLE_USER")
     */
    public function removeModule(Composer $composer, Session $session, Request $request, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $session->removeComposer($composer);
        $manager->flush();
        
        return $this->showSession($session);
    }

    /**
     * @Route("/remove_stagiaire/{id}/{id_stagiaire}", name="session_remove_stagiaire")
     * @Entity("stagiaire", expr="repository.find(id_stagiaire)")
     * @IsGranted("ROLE_USER")
     */
    public function removeStagiaire(Session $session, Stagiaire $stagiaire, Request $request, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $session->removeStagiaire($stagiaire);
        $manager->flush();
        
        return $this->showSession($session);
    }

    /**
     * @Route("/addStagiaire/{id}", name="session_add_stagiaire")
     * @IsGranted("ROLE_USER")
     */
    public function addStagiaire(Session $session, Request $request, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        if (($session->getNbPlaces() - count($session->getStagiaires())) == 0)
        {
            $this->addFlash(
                'notice',
                'Il n\'y a plus de place disponible dans cette formation !'
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
        }

        return $this->render('formation/add_stagiaire.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="session_delete")
     * @IsGranted("ROLE_USER")
     */
    public function deleteSession(Session $session, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        $manager->remove($session);
        $manager->flush();

        return $this->redirectToRoute('formations_list');
    }

    /**
     * @Route("/", name="formations_list")
     */
    public function listFormations(): Response
    {
        $sessions = $this->getDoctrine()
                         ->getRepository(Session::class)
                         ->findAll();

        return $this->render('formation/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }
}