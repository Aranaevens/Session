<?php

namespace App\DataFixtures;

use App\Entity\Stagiaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StagiairesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $ibn = new Stagiaire();
        $ibn->setNom("Ali")
                ->setPrenom("Ibn")
                ->setdateNaissance(new \DateTime("1985-01-17"))
                ->setGenre('Homme')
                ->setEmail('ibn.ali@gmail.com')
                ->setTelephone('0622311344')
                ->setVille('Strasbourg');
        $manager->persist($ibn);

        $nicolas = new Stagiaire();
        $nicolas->setNom("Eisenberg")
                ->setPrenom("Nicolas")
                ->setdateNaissance(new \DateTime("1993-08-05"))
                ->setGenre('Homme')
                ->setEmail('nicolas.eisenberg@gmail.com')
                ->setTelephone('0744332211')
                ->setVille('Strasbourg');
        $manager->persist($nicolas);

        $simon = new Stagiaire();
        $simon->setNom("Machine")
                ->setPrenom("Simon")
                ->setdateNaissance(new \DateTime("1992-01-17"))
                ->setGenre('Homme')
                ->setEmail('simon.machine@gmail.com')
                ->setTelephone('0655677688')
                ->setVille('Seine Saint-Denius');
        $manager->persist($simon);

        $arno = new Stagiaire();
        $arno->setNom("Elbergerdo")
                ->setPrenom("Arnaud")
                ->setdateNaissance(new \DateTime("1992-03-17"))
                ->setGenre('Homme')
                ->setEmail('arnaud.elbergerdo@gmail.com')
                ->setTelephone('0666667788')
                ->setVille('Près des moutons');
        $manager->persist($arno);

        $elias = new Stagiaire();
        $elias->setNom("JeRouleEnPorsche")
                ->setPrenom("Elias")
                ->setdateNaissance(new \DateTime("1991-03-17"))
                ->setGenre('Homme')
                ->setEmail('elias.lamborghini@gmail.com')
                ->setTelephone('0666667788')
                ->setVille('Chez le concessionnaire');
        $manager->persist($elias);

        $sample = new Stagiaire();
        $sample->setNom("Jesaisplus")
                ->setPrenom("Sample")
                ->setdateNaissance(new \DateTime("1988-03-17"))
                ->setGenre('Femme')
                ->setEmail('sample.jesaisplus@gmail.com')
                ->setTelephone('0666667788')
                ->setVille('Somewhere');
        $manager->persist($sample);

        $manager->flush();
    }
}
