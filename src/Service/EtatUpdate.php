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
        $etatOuvert = $etatRepository->findOneBy(['libelle' => 'Ouvert']);

        $dateDuJour = new \DateTime('now');

        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {



            if ($sortie->getDateHeureDebut() < $dateUnMoisAvant) {

                $sortie->setEtat($etatHistorise);
            }
            elseif ($sortie->getParticipantsInscrits()->count() == $sortie->getNbInscriptionMax() || $sortie->getDateLimiteInscription() < $dateDuJour) {
                $sortie->setEtat($etatFermer);
            } elseif ($sortie->getParticipantsInscrits()->count() < $sortie->getNbInscriptionMax()) {
                $sortie->setEtat($etatOuvert);
            }


        }
        $entityManager->flush();




    }

}