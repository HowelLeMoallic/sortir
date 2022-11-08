<?php

namespace App\Service;

use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;

class EtatUpdate
{

    private $entityManager;
    private $etatRepository;

    public function __construct(EntityManagerInterface $entityManager, EtatRepository $etatRepository)
    {
        $this->etatRepository = $etatRepository;
        $this->entityManager = $entityManager;
    }


    public function checkedDate($sorties): void
    {

        $etats = $this->etatRepository->findAll();
        $etatAnnuler = in_array('Annule', $etats);
        $etatEnCreation = in_array('En création', $etats);

        $dateDuJour = new \DateTime('now');



        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {

            $dateFinSorties = clone $sortie->getDateHeureDebut();
            $dateFinSorties->modify('+' . $sortie->getDuree() . ' minutes');

            if ($sortie->getDateHeureDebut() < $dateUnMoisAvant) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Historisé') {
                        $sortie->setEtat($etat);
                    }
                }
            } elseif ($sortie->getEtat() != $etatAnnuler) {
                if ($sortie->getDateHeureDebut() < $dateDuJour and $dateFinSorties > $dateDuJour) {
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

            $this->entityManager->flush();

        }
    }
}

