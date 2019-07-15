<?php

namespace App\DataFixtures;

use App\Entity\Formateur;
use App\Entity\Stagiaire;
use App\Entity\Categorie;
use App\Entity\Composer;
use App\Entity\Modul;
use App\Entity\Session;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class FormateursFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $micka = new Formateur();
        $micka->setNom("Murmann")
                ->setPrenom("Mickael")
                ->setdateNaissance(new \DateTime("1985-01-17"))
                ->setGenre('Homme')
                ->setEmail('mickael.murmann@gmail.com')
                ->setTelephone('0611223344')
                ->setVille('Strasbourg');
        $manager->persist($micka);

        $virgile = new Formateur();
        $virgile->setNom("Gibello")
                ->setPrenom("Virgile")
                ->setdateNaissance(new \DateTime("1985-05-17"))
                ->setGenre('Homme')
                ->setEmail('virgile.gibello@gmail.com')
                ->setTelephone('0644332211')
                ->setVille('Strasbourg');
        $manager->persist($virgile);

        $doe = new Formateur();
        $doe->setNom("Doe")
                ->setPrenom("John")
                ->setdateNaissance(new \DateTime("1980-01-17"))
                ->setGenre('Homme')
                ->setEmail('john.doe@gmail.com')
                ->setTelephone('0655667788')
                ->setVille('Lille');
        $manager->persist($doe);

        $jdoe = new Formateur();
        $jdoe->setNom("Deo")
                ->setPrenom("Jane")
                ->setdateNaissance(new \DateTime("1983-03-17"))
                ->setGenre('Femme')
                ->setEmail('jane.doe@gmail.com')
                ->setTelephone('0666557788')
                ->setVille('Marseille');
        $manager->persist($jdoe);

        $manager->flush();
    }
}
