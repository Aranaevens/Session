<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SessionsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $wordexcel = new Session();
        $wordexcel->setIntitule('Initiation à Word et Excel')
                    ->setDateDebut('2018-06-17')
                    ->setDateFin('2018-06-29')
                    ->setNbPlaces(8);
        $manager->persist($wordexcel);

        $wordtoshop = new Session();
        $wordtoshop->setIntitule('Perfectionnement Word et Photoshop')
                    ->setDateDebut('2018-07-08')
                    ->setDateFin('2018-07-12')
                    ->setNbPlaces(6);
        $manager->persist($wordtoshop);

        $dl = new Session();
        $dl->setIntitule('Developpeur Web / Web Mobile')
            ->setDateDebut('2019-05-15')
            ->setDateFin('2019-12-17')
            ->setNbPlaces(12);
        $manager->persist($dl);

        $manager->flush();
    }
}
