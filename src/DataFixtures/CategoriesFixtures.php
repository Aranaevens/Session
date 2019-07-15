<?php

namespace App\DataFixtures;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Stagiaire;

use App\DataFixtures\FormateursFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Formateur::class);
    }
    
    public function load(ObjectManager $manager)
    {
        $micka = $this->repository->findByName('Mickael', 'Murmann');
        $virgile = $this->repository->findByName('Virgile', 'Gibello');
        $jane = $this->repository->findByName('Jane', 'Doe');
        
        $buro = new Categorie();
        $buro->setIntitule('Bureautique');
        $buro->addFormateur($micka);
        $manager->persist($buro);

        $micka->addCategorie($buro);

        $informatique = new Categorie();
        $informatique->setIntitule('Developpement');
        $informatique->addFormateur($micka);
        $informatique->addFormateur($virgile);
        $manager->persist($informatique);

        $micka->addCategorie($informatique);
        $virgile->addCategorie($informatique);

        $graphie = new Categorie();
        $graphie->setIntitule('Infographie');
        $graphie->addFormateur($micka);
        $graphie->addFormateur($jane);
        $manager->persist($graphie);

        $micka->addCategorie($graphie);
        $jane->addCategorie($graphie);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            FormateursFixtures::class,
        );
    }
}
