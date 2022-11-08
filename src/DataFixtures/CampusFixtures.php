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
        $this->addReference('campus0', $quimper);
        $manager->persist($quimper);


        $nantes = new Campus();
        $nantes->setNom('Nantes');
        $this->addReference('campus1', $nantes);
        $manager->persist($nantes);

        $rennes = new Campus();
        $rennes->setNom('Rennes');
        $this->addReference('campus2', $rennes);
        $manager->persist($rennes);

        $niort = new Campus();
        $niort->setNom('Niort');
        $this->addReference('campus3', $niort);
        $manager->persist($niort);

        $manager->flush();
    }
}
