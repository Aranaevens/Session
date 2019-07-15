<?php

namespace App\DataFixtures;

use App\Entity\Modul;
use App\Entity\Session;
use App\Entity\Composer;
use App\DataFixtures\ModulesFixtures;
use App\DataFixtures\SessionsFixtures;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ComposerFixtures extends Fixture implements DependentFixtureInterface
{
    private $repositorySession;
    private $repositoryModule;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repositorySession = $em->getRepository(Session::class);
        $this->repositoryModule = $em->getRepository(Modul::class);
    }
    public function load(ObjectManager $manager)
    {
        $wordexcel = $this->repositorySession->findByIntitule('Initiation à Word et Excel');
        $wordtoshop = $this->repositorySession->findByIntitule('Perfectionnement Word et Photoshop');
        $dl = $this->repositorySession->findByIntitule('Developpeur Web / Web Mobile');

        $word = $this->repositoryModule->findByIntitule('Word');
        $excel = $this->repositoryModule->findByIntitule('Excel');
        $outlook = $this->repositoryModule->findByIntitule('Outlook');
        $php = $this->repositoryModule->findByIntitule('PHP');
        $sql = $this->repositoryModule->findByIntitule('SQL');
        $symfony = $this->repositoryModule->findByIntitule('Symfony');
        $photoshop = $this->repositoryModule->findByIntitule('Photoshop');

        // Couples for wordexcel
        $un = new Composer();
        $un->setNbJours(2)
            ->addModule($word)
            ->addSession($wordexcel);
        $manager->persist($un);
        $deux = new Composer();
        $deux->setNbJours(2)
            ->addModule($excel)
            ->addSession($wordexcel);
        $manager->persist($deux);

        // Couples for wordtoshop
        $trois = new Composer();
        $trois->setNbJours(3)
            ->addModule($word)
            ->addSession($wordtoshop);
        $manager->persist($trois);
        $quatre = new Composer();
        $quatre->setNbJours(3)
            ->addModule($photoshop)
            ->addSession($wordtoshop);
        $manager->persist($quatre);

        // Couples for DL
        $cinq = new Composer();
        $cinq->setNbJours(45)
            ->addModule($php)
            ->addSession($dl);
        $manager->persist($cinq);
        $six = new Composer();
        $six->setNbJours(7)
            ->addModule($sql)
            ->addSession($dl);
        $manager->persist($six);
        $sept = new Composer();
        $sept->setNbJours(30)
            ->addModule($symfony)
            ->addSession($dl);
        $manager->persist($sept);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            SessionsFixtures::class,
            ModulesFixtures::class,
        );
    }
}
