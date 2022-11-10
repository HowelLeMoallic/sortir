<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $piqueNique = new Sortie();
        $piqueNique->setNom('Pique-nique');
        $piqueNique->setDateHeureDebut(new \DateTime('2022-11-12 09:39:40'));
        $piqueNique->setDateLimiteInscription(new \DateTime('2022-11-11 09:39:40'));
        $piqueNique->setDuree(300);
        $piqueNique->setCampus($this->getReference('campus0'));
        $piqueNique->setEtat($this->getReference('etat1'));
        $piqueNique->setInfosSortie('Pique Nique avec les étudiants');
        $piqueNique->setLieu($this->getReference('lieu0'));
        $piqueNique->setNbInscriptionMax(1);
        $piqueNique->setOrganisateur($this->getReference('user1'));
        $manager->persist($piqueNique);

        $patinoire = new Sortie();
        $patinoire->setNom('Patinoire');
        $patinoire->setDateHeureDebut(new \DateTime('2022-11-15 09:39:40'));
        $patinoire->setDateLimiteInscription(new \DateTime('2022-11-13 09:39:40'));
        $patinoire->setDuree(180);
        $patinoire->setCampus($this->getReference('campus2'));
        $patinoire->setEtat($this->getReference('etat0'));
        $patinoire->setInfosSortie('patinoire avec les étudiants');
        $patinoire->setLieu($this->getReference('lieu1'));
        $patinoire->setNbInscriptionMax(8);
        $patinoire->setOrganisateur($this->getReference('user2'));
        $manager->persist($patinoire);

        $patinoire1 = new Sortie();
        $patinoire1->setNom('Bowling');
        $patinoire1->setDateHeureDebut(new \DateTime('2022-11-16 09:39:40'));
        $patinoire1->setDateLimiteInscription(new \DateTime('2022-11-15 09:39:40'));
        $patinoire1->setDuree(180);
        $patinoire1->setCampus($this->getReference('campus2'));
        $patinoire1->setEtat($this->getReference('etat1'));
        $patinoire1->setInfosSortie('Bowling avec les étudiants');
        $patinoire1->setLieu($this->getReference('lieu1'));
        $patinoire1->setNbInscriptionMax(8);
        $patinoire1->setOrganisateur($this->getReference('user2'));
        $manager->persist($patinoire1);

        $patinoire2 = new Sortie();
        $patinoire2->setNom('Patinoire2');
        $patinoire2->setDateHeureDebut(new \DateTime('2022-11-14 09:39:40'));
        $patinoire2->setDateLimiteInscription(new \DateTime('2022-11-12 09:39:40'));
        $patinoire2->setDuree(180);
        $patinoire2->setCampus($this->getReference('campus2'));
        $patinoire2->setEtat($this->getReference('etat0'));
        $patinoire2->setInfosSortie('patinoire avec les étudiants');
        $patinoire2->setLieu($this->getReference('lieu1'));
        $patinoire2->setNbInscriptionMax(8);
        $patinoire2->setOrganisateur($this->getReference('user2'));
        $manager->persist($patinoire2);


        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 200; $i++) {
            $sortie[$i] = new Sortie();
            $sortie[$i]->setNom($faker->sentence(3));
            $sortie[$i]->setDateHeureDebut($faker->dateTimeBetween('now', '+ 2years'));
            $dateSortie = clone $sortie[$i]->getDateHeureDebut();
            $sortie[$i]->setDateLimiteInscription($faker->dateTimeBetween('now', $dateSortie));
            $sortie[$i]->setDuree($faker->randomNumber());
            $sortie[$i]->setCampus($this->getReference('campus'.rand(0,3)));
            $sortie[$i]->setEtat($this->getReference('etat'.rand(0,6)));
            $sortie[$i]->setInfosSortie($faker->realText(100));
            $sortie[$i]->setLieu($this->getReference('lieu'.rand(0,3)));
            $sortie[$i]->setNbInscriptionMax($faker->numberBetween(1, 100));
            $sortie[$i]->setOrganisateur($this->getReference('user'.rand(0,24)));
            $manager->persist($sortie[$i]);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [CampusFixtures::class, EtatFixtures::class, LieuFixtures::class];
    }
}
