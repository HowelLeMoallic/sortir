<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $centreVillePloneis = new Lieu();
        $centreVillePloneis->setNom('Centre ville de Plonéis');
        $centreVillePloneis->setVille($this->getReference('ploneis'));
        $centreVillePloneis->setRue('Rue du centre ville');
        $centreVillePloneis->setLatitude(10.45);
        $centreVillePloneis->setLongitude(45.26);
        $this->addReference('centreVillePloneis', $centreVillePloneis);
        $manager->persist($centreVillePloneis);

        $campusKerLann = new Lieu();
        $campusKerLann->setNom('Campus de Ker Lann');
        $campusKerLann->setVille($this->getReference('bruz'));
        $campusKerLann->setRue('Rue du campus');
        $campusKerLann->setLatitude(-60.63);
        $campusKerLann->setLongitude(33.52);
        $this->addReference('campusKerLann', $campusKerLann);
        $manager->persist($campusKerLann);

        $egliseDeChauray = new Lieu();
        $egliseDeChauray->setNom('Eglise de Chauray');
        $egliseDeChauray->setVille($this->getReference('chauray'));
        $egliseDeChauray->setRue('Rue de l\'église');
        $egliseDeChauray->setLatitude(40.98);
        $egliseDeChauray->setLongitude(-5.06);
        $this->addReference('egliseDeChauray', $egliseDeChauray);
        $manager->persist($egliseDeChauray);

        $placeDorvault = new Lieu();
        $placeDorvault->setNom('Place d\'Orvault');
        $placeDorvault->setVille($this->getReference('orvault'));
        $placeDorvault->setRue('Rue de la place d\'Orvault');
        $placeDorvault->setLatitude(89.75);
        $placeDorvault->setLongitude(50.20);
        $this->addReference('placeDorvault', $placeDorvault);
        $manager->persist($placeDorvault);

        $manager->flush();

    }


    public function getDependencies()
    {
        return[VilleFixtures::class];
    }
}
