<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Composer;
use App\Form\ModuleType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/modules")
 */
class ModuleController extends AbstractController
{
    /**
     * @Route("/add", name="module_add")
     */
    public function addModule(Request $request, ObjectManager $manager)
    {
        $module = new Modul();

        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($module);

            // $duree = new Composer();
            // $duree->setNbJours($form->get('nbjours')->getData());
            // $duree->setSession($formation);
            // $duree->setModule($module);
            // $manager->persist($duree);
            
            $manager->flush();

            return $this->redirectToRoute('modules_list');
        }
        return $this->render('formation/add_module.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="module_delete")
     */
    public function deleteModule(Modul $module, ObjectManager $manager) : Response {
        $manager->remove($module);
        $manager->flush();

        return $this->redirectToRoute('modules_list');
    }

    /**
     * @Route("/{id}", name="module_show")
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
     * @Route("/", name="modules_list")
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
}
