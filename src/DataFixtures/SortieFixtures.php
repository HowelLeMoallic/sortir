<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $piqueNique = new Sortie();
        $piqueNique->setNom('Pique-nique');
        $piqueNique->setDateHeureDebut(new \DateTime('2022-11-03 09:39:40'));
        $piqueNique->setDateLimiteInscription(new \DateTime());
        $piqueNique->setDuree(new \DateTime('05:00:00'));
        $piqueNique->setCampus($this->getReference('quimper'));
        $piqueNique->setEtat($this->getReference('ouvert'));
        $piqueNique->setInfosSortie('pique Nique avec les étudiants');
        $piqueNique->setLieu($this->getReference('centreVillePloneis'));
        $piqueNique->setNbInscriptionMax(10);
        $piqueNique->setOrganisateur($this->getReference('howel'));
        $manager->persist($piqueNique);

        $patinoire = new Sortie();
        $patinoire->setNom('Patinoire');
        $patinoire->setDateHeureDebut(new \DateTime('2022-11-08 09:39:40'));
        $patinoire->setDateLimiteInscription(new \DateTime('2022-11-03 09:39:40'));
        $patinoire->setDuree(new \DateTime('03:00:00'));
        $patinoire->setCampus($this->getReference('rennes'));
        $patinoire->setEtat($this->getReference('fermer'));
        $patinoire->setInfosSortie('patinoire avec les étudiants');
        $patinoire->setLieu($this->getReference('campusKerLann'));
        $patinoire->setNbInscriptionMax(8);
        $patinoire->setOrganisateur($this->getReference('tanguy'));
        $manager->persist($patinoire);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class, EtatFixtures::class, LieuFixtures::class];
    }
}
