<?php

namespace App\DataFixtures;

use App\Entity\Campus;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $quimper = new Campus();
        $quimper->setNom('Quimper');
        $manager->persist($quimper);

        $nantes = new Campus();
        $nantes->setNom('Nantes');
        $manager->persist($nantes);

        $rennes = new Campus();
        $rennes->setNom('Rennes');
        $manager->persist($rennes);

        $niort = new Campus();
        $niort->setNom('Niort');
        $manager->persist($niort);

        $manager->flush();
    }
}
