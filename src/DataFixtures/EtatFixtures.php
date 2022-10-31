<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $enCreation = new Etat();
        $enCreation->setLibelle('En création');
        $manager->persist($enCreation);

        $ouvert = new Etat();
        $ouvert->setLibelle('Ouvert');
        $manager->persist($ouvert);

        $enCours = new Etat();
        $enCours->setLibelle('En cours');
        $manager->persist($enCours);

        $fermer = new Etat();
        $fermer->setLibelle('Fermé');
        $manager->persist($fermer);

        $terminer = new Etat();
        $terminer->setLibelle('Terminé');
        $manager->persist($terminer);

        $annuler = new Etat();
        $annuler->setLibelle('Annulé');
        $manager->persist($annuler);

        $historiser = new Etat();
        $historiser->setLibelle('Historisé');
        $manager->persist($historiser);



        $manager->flush();
    }
}
