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

        $patinoire1 = new Sortie();
        $patinoire1->setNom('Patinoire1');
        $patinoire1->setDateHeureDebut(new \DateTime('2022-11-08 09:39:40'));
        $patinoire1->setDateLimiteInscription(new \DateTime('2022-11-03 09:39:40'));
        $patinoire1->setDuree(new \DateTime('03:00:00'));
        $patinoire1->setCampus($this->getReference('rennes'));
        $patinoire1->setEtat($this->getReference('ouvert'));
        $patinoire1->setInfosSortie('patinoire avec les étudiants');
        $patinoire1->setLieu($this->getReference('campusKerLann'));
        $patinoire1->setNbInscriptionMax(8);
        $patinoire1->setOrganisateur($this->getReference('tanguy'));
        $manager->persist($patinoire1);

        $patinoire2 = new Sortie();
        $patinoire2->setNom('Patinoire2');
        $patinoire2->setDateHeureDebut(new \DateTime('2022-11-08 09:39:40'));
        $patinoire2->setDateLimiteInscription(new \DateTime('2022-11-03 09:39:40'));
        $patinoire2->setDuree(new \DateTime('03:00:00'));
        $patinoire2->setCampus($this->getReference('rennes'));
        $patinoire2->setEtat($this->getReference('enCreation'));
        $patinoire2->setInfosSortie('patinoire avec les étudiants');
        $patinoire2->setLieu($this->getReference('campusKerLann'));
        $patinoire2->setNbInscriptionMax(8);
        $patinoire2->setOrganisateur($this->getReference('tanguy'));
        $manager->persist($patinoire2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class, EtatFixtures::class, LieuFixtures::class];
    }
}
