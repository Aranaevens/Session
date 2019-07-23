<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Composer;
use App\Form\ModuleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/modules")
 */
class ModuleController extends AbstractController
{
    /**
     * @Route("/add", name="module_add")
     * @Route("/edit/{id}", name="module_edit")
     * @IsGranted("ROLE_USER")
     */
    public function addModule(Modul $module = null, Request $request, ObjectManager $manager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
        if (!$module)
        {
            $module = new Modul();
        }
        $form = $this->createForm(ModuleType::class, $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($module);
            $manager->flush();

            return $this->redirectToRoute('modules_list');
        }
        return $this->render('module/add_edit.html.twig',[
            'form'=>$form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="module_delete")
     * @IsGranted("ROLE_USER")
     */
    public function deleteModule(Modul $module, ObjectManager $manager) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        
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

        return $this->render('module/modules_show.html.twig', [
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
                        ->findAllOrder();

        return $this->render('module/modules_list.html.twig', [
            'modules' => $modules,
        ]);
    }
}
