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
        $this->addReference('etat0', $enCreation);
        $manager->persist($enCreation);

        $ouvert = new Etat();
        $ouvert->setLibelle('Ouvert');
        $this->addReference('etat1', $ouvert);
        $manager->persist($ouvert);

        $enCours = new Etat();
        $enCours->setLibelle('En cours');
        $this->addReference('etat2', $enCours);
        $manager->persist($enCours);

        $fermer = new Etat();
        $fermer->setLibelle('Fermé');
        $this->addReference('etat3', $fermer);
        $manager->persist($fermer);

        $terminer = new Etat();
        $terminer->setLibelle('Terminé');
        $this->addReference('etat4', $terminer);
        $manager->persist($terminer);

        $annuler = new Etat();
        $annuler->setLibelle('Annulé');
        $this->addReference('etat5', $annuler);
        $manager->persist($annuler);

        $historiser = new Etat();
        $historiser->setLibelle('Historisé');
        $this->addReference('etat6', $historiser);
        $manager->persist($historiser);

        $manager->flush();
    }
}
