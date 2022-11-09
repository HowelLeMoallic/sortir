<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

//      Ville auprès de Quimper

        $ploneis = new Ville();
        $ploneis->setNom('Plonéis');
        $ploneis->setCodePostal('29710');
        $this->addReference('ploneis', $ploneis);
        $manager->persist($ploneis);

        $quimper = new Ville();
        $quimper->setNom('Quimper');
        $quimper->setCodePostal('29000');
        $this->addReference('quimper', $quimper);
        $manager->persist($quimper);

        $pluguffan = new Ville();
        $pluguffan->setNom('Pluguffan');
        $pluguffan->setCodePostal('29700');
        $this->addReference('pluguffan', $pluguffan);
        $manager->persist($pluguffan);

        $ergue_gaberic = new Ville();
        $ergue_gaberic->setNom('Ergué-Gabéric');
        $ergue_gaberic->setCodePostal('29500');
        $this->addReference('ergue-gaberic', $ergue_gaberic);
        $manager->persist($ergue_gaberic);

        $pont_labbe = new Ville();
        $pont_labbe->setNom('Pont l\'Abbé');
        $pont_labbe->setCodePostal('29120');
        $this->addReference('pont_labbe', $pont_labbe);
        $manager->persist($pont_labbe);





//        Ville auprè de Rennes


        $bruz = new Ville();
        $bruz->setNom('Bruz');
        $bruz->setCodePostal('35170');
        $this->addReference('bruz', $bruz);
        $manager->persist($bruz);

        $rennes = new Ville();
        $rennes->setNom('Rennes');
        $rennes->setCodePostal('35000');
        $this->addReference('rennes', $rennes);
        $manager->persist($rennes);

        $vezin_le_coquet = new Ville();
        $vezin_le_coquet->setNom('Vezin-le-Coquet');
        $vezin_le_coquet->setCodePostal('35132');
        $this->addReference('vezin_le_coquet', $vezin_le_coquet);
        $manager->persist($vezin_le_coquet);

        $chantepie = new Ville();
        $chantepie->setNom('Chantepie');
        $chantepie->setCodePostal('35135');
        $this->addReference('chantepie', $chantepie);
        $manager->persist($chantepie);

        $chartres_de_bretagne = new Ville();
        $chartres_de_bretagne->setNom('Chartres-de-Bretagne');
        $chartres_de_bretagne->setCodePostal('35131');
        $this->addReference('chartres_de_bretagne', $chartres_de_bretagne);
        $manager->persist($chartres_de_bretagne);

        $cesson_sevigne = new Ville();
        $cesson_sevigne->setNom('Cesson-Sévigné');
        $cesson_sevigne->setCodePostal('35510');
        $this->addReference('cesson_sevigne', $cesson_sevigne);
        $manager->persist($cesson_sevigne);




//        Ville auprès de Niort

        $chauray = new Ville();
        $chauray->setNom('Chauray');
        $chauray->setCodePostal('79180');
        $this->addReference('chauray', $chauray);
        $manager->persist($chauray);

        $niort = new Ville();
        $niort->setNom('Niort');
        $niort->setCodePostal('79000');
        $this->addReference('niort', $niort);
        $manager->persist($niort);

        $echire = new Ville();
        $echire->setNom('Échiré');
        $echire->setCodePostal('79410');
        $this->addReference('echire', $echire);
        $manager->persist($echire);

        $aiffres = new Ville();
        $aiffres->setNom('Aiffres');
        $aiffres->setCodePostal('79230');
        $this->addReference('aiffres', $aiffres);
        $manager->persist($aiffres);

        $fontenay_rohan_rohan = new Ville();
        $fontenay_rohan_rohan->setNom('Fontenay-Rohan-Rohan');
        $fontenay_rohan_rohan->setCodePostal('79270');
        $this->addReference('fontenay_rohan_rohan', $fontenay_rohan_rohan);
        $manager->persist($fontenay_rohan_rohan);


//        Ville auprès de Nantes

        $orvault = new Ville();
        $orvault->setNom('Orvault');
        $orvault->setCodePostal('44700');
        $this->addReference('orvault', $orvault);
        $manager->persist($orvault);

        $nantes = new Ville();
        $nantes->setNom('Nantes');
        $nantes->setCodePostal('44000');
        $this->addReference('nantes', $nantes);
        $manager->persist($nantes);

        $saint_herblain = new Ville();
        $saint_herblain->setNom('Saint-Herblain');
        $saint_herblain->setCodePostal('44800');
        $this->addReference('saint_herblain', $saint_herblain);
        $manager->persist($saint_herblain);

        $vertou = new Ville();
        $vertou->setNom('Vertou');
        $vertou->setCodePostal('44120');
        $this->addReference('vertou', $vertou);
        $manager->persist($vertou);

        $reze = new Ville();
        $reze->setNom('Rezé');
        $reze->setCodePostal('44400');
        $this->addReference('reze', $reze);
        $manager->persist($reze);

        $carquefou = new Ville();
        $carquefou->setNom('Carquefou');
        $carquefou->setCodePostal('44470');
        $this->addReference('carquefou', $carquefou);
        $manager->persist($carquefou);


        $manager->flush();
    }
}
