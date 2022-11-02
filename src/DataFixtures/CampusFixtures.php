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
        $this->addReference('quimper', $quimper);
        $manager->persist($quimper);


        $nantes = new Campus();
        $nantes->setNom('Nantes');
        $this->addReference('nantes', $nantes);
        $manager->persist($nantes);

        $rennes = new Campus();
        $rennes->setNom('Rennes');
        $this->addReference('rennes', $rennes);
        $manager->persist($rennes);

        $niort = new Campus();
        $niort->setNom('Niort');
        $this->addReference('niort', $niort);
        $manager->persist($niort);

        $manager->flush();
    }
}
