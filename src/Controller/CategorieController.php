<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Categorie;
use App\Form\CategoryType;
use App\Form\ModuleCategorieType;
use App\Form\FormateurCategorieType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/categories")
 */
class CategorieController extends AbstractController
{
    /**
     * @Route("/add", name="categorie_add")
     * @Route("/{id}/edit", name="categorie_edit")
     */
    public function addCategorie(Categorie $categorie = null, Request $request, ObjectManager $manager): Response
    {
        if (!$categorie)
        {
            $categorie = new Categorie();
        }
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($categorie);
            $manager->flush();

            return $this->redirectToRoute('categorie_add_module', [
                'id' => $categorie->getId(),
            ]);
        }
        return $this->render('categorie/add_edit.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addModule", name="categorie_add_module")
     */
    public function addModule(Categorie $categorie, Request $request, ObjectManager $manager): Response
    {
        $form = $this->createForm(ModuleCategorieType::class);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($form->get('module')->getData() as $module)
            {
                $categorie->addModule($module);
            }
            $manager->flush();

            return $this->redirectToRoute('modules_list');
        }

        return $this->render('categorie/add_module.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addFormateur", name="categorie_add_formateur")
     */
    public function addFormateur(Categorie $categorie, Request $request, ObjectManager $manager): Response
    {
        $form = $this->createForm(FormateurCategorieType::class);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid())
        {
            foreach ($form->get('formateur')->getData() as $formateur)
            {
                $categorie->addFormateur($formateur);
            }
            $manager->flush();

            return $this->redirectToRoute('modules_list');
        }

        return $this->render('categorie/add_formateur.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/delete", name="categorie_delete")
     */
    public function deleteCategorie(Modul $categorie, ObjectManager $manager) : Response
    {
        $manager->remove($categorie);
        $manager->flush();

        return $this->redirectToRoute('modules_list');
    }
}
