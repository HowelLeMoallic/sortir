<?php

namespace App\Service;

use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;

class EtatUpdate
{
    public function checkedDate(EtatRepository $etatRepository, EntityManagerInterface $entityManager, $sorties): void
    {

        $etats = $etatRepository->findAll();
        $etatAnnuler = in_array('Annule', $etats);
        $etatEnCreation = in_array('En création', $etats);

        $dateDuJour = new \DateTime('now');

        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {

            if ($sortie->getDateHeureDebut() < $dateUnMoisAvant) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Historisé') {
                        $sortie->setEtat($etat);
                    }
                }
            } elseif ($sortie->getEtat() != $etatAnnuler) {
                if ($sortie->getDateHeureDebut() == $dateDuJour) {
                    foreach ($etats as $etat) {
                        if ($etat->getLibelle() == 'En cours') {
                            $sortie->setEtat($etat);
                        }
                    }
                }
            } elseif ($sortie->getDateHeureDebut() < $dateDuJour) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Terminé') {
                        $sortie->setEtat($etat);
                    }
                }
            } elseif ($sortie->getParticipantsInscrits()->count() == $sortie->getNbInscriptionMax() || $sortie->getDateLimiteInscription() < $dateDuJour) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Fermé') {
                        $sortie->setEtat($etat);
                    }
                }
            } elseif ($sortie->getParticipantsInscrits()->count() < $sortie->getNbInscriptionMax() and $sortie->getEtat() != $etatEnCreation ) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Ouvert') {
                        $sortie->setEtat($etat);
                    }
                }
            }


            $entityManager->flush();

        }
    }
}

