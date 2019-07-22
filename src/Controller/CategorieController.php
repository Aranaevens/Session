<?php

namespace App\Controller;

use App\Entity\Modul;
use App\Entity\Composer;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Form\CategoryType;
use App\Form\ModuleCategorieType;
use App\Form\FormateurCategorieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
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
    public function deleteCategorie(Categorie $categorie, ObjectManager $manager) : Response
    {
        $manager->remove($categorie);
        $manager->flush();

        return $this->redirectToRoute('categories_list');
    }

    /**
     * @Route("/{id}/modules", name="modules_list_category")
     */
    public function listModules(Categorie $categorie, ObjectManager $manager) : Response
    {
        $modules = $this->getDoctrine()
                        ->getRepository(Composer::class)
                        ->findByCategorie($categorie->getId());

        return $this->render('categorie/mod_list.html.twig', [
            'modules' => $modules
        ]);
    }

    /**
     * @Route("/{id}/formateurs", name="formateurs_list_category")
     */
    public function listFormateurs(Categorie $categorie, ObjectManager $manager) : Response
    {
        $formateurs = $this->getDoctrine()
                        ->getRepository('App\Entity\Formateur')
                        ->findByCategorie($categorie->getId());

        return $this->render('categorie/form_list.html.twig', [
            'formateurs' => $formateurs
        ]);
    }

    /**
     * @Route("/", name="categories_list")
     */
    public function listCategorie() : Response
    {
        $categories = $this->getDoctrine()
                        ->getRepository(Categorie::class)
                        ->findAll();

        return $this->render('categorie/categories_list.html.twig', [
            'categories' => $categories
        ]);
    }
}
