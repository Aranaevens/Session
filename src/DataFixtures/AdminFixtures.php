<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $adm = new User();
        $adm->setEmail('sudo@superadmin.elan.fr')
            ->setPassword($this->encoder->encodePassword(
                $adm, 'admin'));
        $manager->persist($adm);

        $manager->flush();
    }
}
