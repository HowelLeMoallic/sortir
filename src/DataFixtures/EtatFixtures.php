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
        $this->addReference('enCreation', $enCreation);
        $manager->persist($enCreation);

        $ouvert = new Etat();
        $ouvert->setLibelle('Ouvert');
        $this->addReference('ouvert', $ouvert);
        $manager->persist($ouvert);

        $enCours = new Etat();
        $enCours->setLibelle('En cours');
        $this->addReference('enCours', $enCours);
        $manager->persist($enCours);

        $fermer = new Etat();
        $fermer->setLibelle('Fermé');
        $this->addReference('fermer', $fermer);
        $manager->persist($fermer);

        $terminer = new Etat();
        $terminer->setLibelle('Terminé');
        $this->addReference('terminer', $terminer);
        $manager->persist($terminer);

        $annuler = new Etat();
        $annuler->setLibelle('Annulé');
        $this->addReference('annuler', $annuler);
        $manager->persist($annuler);

        $historiser = new Etat();
        $historiser->setLibelle('Historisé');
        $this->addReference('historiser', $historiser);
        $manager->persist($historiser);

        $manager->flush();
    }
}
