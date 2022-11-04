<?php

namespace App\Service;

use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;

class EtatUpdate
{
    public function CheckedDate(SortieRepository $sortieRepository, EtatRepository $etatRepository, EntityManagerInterface $entityManager):void
    {
        $sorties = $sortieRepository->findAll();
        $etatHistorise = $etatRepository->findOneBy(['libelle' => 'Historisé']);
        $etatFermer = $etatRepository->findOneBy(['libelle' => 'Fermé']);

        $dateDuJour = new \DateTime('now');

        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {

            if ($sortie->getDateHeureDebut() < $dateUnMoisAvant) {

                $sortie->setEtat($etatHistorise);
            }
            elseif ($sortie->getDateLimiteInscription() < $dateDuJour) {

                $sortie->setEtat($etatFermer);

            }

        }
        $entityManager->flush();




    }

}