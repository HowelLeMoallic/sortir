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

        $dateDuJour = new \DateTime('now');

        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {

            if ($sortie->getDateHeureDebut() < $dateUnMoisAvant) {
                $sortie->setEtat($etatRepository->findOneBy(['libelle' => 'Historisé']));
            }
            elseif ($sortie->getDateLimiteInscription() < $dateDuJour) {
                $sortie->setEtat($etatRepository->findOneBy(['libelle' => 'Fermé']));
            }
        }

        $entityManager->flush();

    }

}