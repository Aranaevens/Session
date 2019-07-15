<?php

namespace App\DataFixtures;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\Entity\Categorie;
use App\Entity\Formateur;
use App\Entity\Stagiaire;

use App\DataFixtures\ModulesFixtures;
use App\DataFixtures\FormateursFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoriesFixtures extends Fixture implements DependentFixtureInterface
{
    private $repositoryFormateur;
    private $repositoryModule;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repositoryFormateur = $em->getRepository(Formateur::class);
        $this->repositoryModule = $em->getRepository(Modul::class);
    }
    
    public function load(ObjectManager $manager)
    {
        $micka = $this->repositoryFormateur->findByName('Murmann');
        $virgile = $this->repositoryFormateur->findByName('Gibello');
        $jane = $this->repositoryFormateur->findByName('Deo');
        
        $word = $this->repositoryModule->findByIntitule('Word');
        $excel = $this->repositoryModule->findByIntitule('Excel');
        $outlook = $this->repositoryModule->findByIntitule('Outlook');
        $php = $this->repositoryModule->findByIntitule('PHP');
        $sql = $this->repositoryModule->findByIntitule('SQL');
        $symfony = $this->repositoryModule->findByIntitule('Symfony');
        $photoshop = $this->repositoryModule->findByIntitule('Photoshop');
        
        $buro = new Categorie();
        $buro->setIntitule('Bureautique');
        $buro->addFormateur($micka);
        $buro->addModule($word);
        $buro->addModule($excel);
        $buro->addModule($outlook);
        $manager->persist($buro);

        // $micka->addCategorie($buro);

        $informatique = new Categorie();
        $informatique->setIntitule('Developpement');
        $informatique->addFormateur($micka);
        $informatique->addFormateur($virgile);
        $informatique->addModule($php);
        $informatique->addModule($sql);
        $informatique->addModule($symfony);
        $manager->persist($informatique);

        // $micka->addCategorie($informatique);
        // $virgile->addCategorie($informatique);

        $graphie = new Categorie();
        $graphie->setIntitule('Infographie');
        $graphie->addFormateur($micka);
        $graphie->addFormateur($jane);
        $graphie->addModule($photoshop);
        $manager->persist($graphie);

        // $micka->addCategorie($graphie);
        // $jane->addCategorie($graphie);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            FormateursFixtures::class,
            ModulesFixtures::class,
        );
    }
}
