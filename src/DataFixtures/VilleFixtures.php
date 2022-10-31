<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ploneis = new Ville();
        $ploneis->setNom('Plonéis');
        $ploneis->setCodePostal('29710');
        $manager->persist($ploneis);

        $bruz = new Ville();
        $bruz->setNom('Bruz');
        $bruz->setCodePostal('35170');
        $manager->persist($bruz);

        $chauray = new Ville();
        $chauray->setNom('Chauray');
        $chauray->setCodePostal('79180');
        $manager->persist($chauray);

        $orvault = new Ville();
        $orvault->setNom('Orvault');
        $orvault->setCodePostal('44700');
        $manager->persist($orvault);

        $manager->flush();
    }
}
