<?php

namespace App\DataFixtures;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SessionsFixtures extends Fixture
{
    private $repositoryStagiaire;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repositoryStagiaire = $em->getRepository(Stagiaire::class);
    }
    public function load(ObjectManager $manager)
    {
        $ibn = $this->repositoryStagiaire->findByName('Ibn', 'Ali');
        $nicolas = $this->repositoryStagiaire->findByName('Nicolas', 'Eisenberg');
        $simon = $this->repositoryStagiaire->findByName('Simon', 'Machine');
        $arno = $this->repositoryStagiaire->findByName('Arnaud', 'Elbergerdo');
        $elias = $this->repositoryStagiaire->findByName('Elias', 'JeRouleEnPorsche');
        $sample = $this->repositoryStagiaire->findByName('Sample', 'Jesaisplus');
        
        $wordexcel = new Session();
        $wordexcel->setIntitule('Initiation à Word et Excel')
                    ->setDateDebut('2018-06-17')
                    ->setDateFin('2018-06-29')
                    ->setNbPlaces(8)
                    ->addStagiaire($sample);
        $manager->persist($wordexcel);

        $wordtoshop = new Session();
        $wordtoshop->setIntitule('Perfectionnement Word et Photoshop')
                    ->setDateDebut('2018-07-08')
                    ->setDateFin('2018-07-12')
                    ->setNbPlaces(6)
                    ->addStagiaire($sample)
                    ->addStagiaire($simon)
                    ->addStagiaire($elias);
        $manager->persist($wordtoshop);

        $dl = new Session();
        $dl->setIntitule('Developpeur Web / Web Mobile')
            ->setDateDebut('2019-05-15')
            ->setDateFin('2019-12-17')
            ->setNbPlaces(12)
            ->addStagiaire($ibn)
            ->addStagiaire($nicolas)
            ->addStagiaire($simon)
            ->addStagiaire($arno)
            ->addStagiaire($elias);
        $manager->persist($dl);

        $manager->flush();
    }
}
