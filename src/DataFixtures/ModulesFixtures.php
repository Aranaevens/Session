<?php

namespace App\DataFixtures;

use App\Entity\Modul;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ModulesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $word = new Modul();
        $word->setIntitule('Word');
        $manager->persist($word);

        $excel = new Modul();
        $excel->setIntitule('Excel');
        $manager->persist($excel);

        $outlook = new Modul();
        $outlook->setIntitule('Outlook');
        $manager->persist($outlook);

        $photoshop = new Modul();
        $photoshop->setIntitule('Photoshop');
        $manager->persist($photoshop);

        $php = new Modul();
        $php->setIntitule('PHP');
        $manager->persist($php);

        $symfony = new Modul();
        $symfony->setIntitule('Symfony');
        $manager->persist($symfony);

        $sql = new Modul();
        $sql->setIntitule('SQL');
        $manager->persist($sql);

        $manager->flush();
    }
}
