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
        $etatTerminer = in_array('Terminé', $etats);

        $dateDuJour = new \DateTime('now');



        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {

            $dateFinSorties = clone $sortie->getDateHeureDebut();
            $dateFinSorties->modify('+' . $sortie->getDuree() . ' minutes');


            if ($sortie->getEtat() != $etatAnnuler) {

                if ($sortie->getDateHeureDebut() < $dateDuJour and $dateFinSorties > $dateDuJour) {

                    foreach ($etats as $etat) {

                        if ($etat->getLibelle() == 'En cours') {
                            $sortie->setEtat($etat);

                        }
                    }
                }
            }
            if (($sortie->getParticipantsInscrits()->count() == $sortie->getNbInscriptionMax() || $sortie->getDateLimiteInscription() < $dateDuJour) and $sortie->getEtat() != $etatTerminer) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Fermé') {
                        $sortie->setEtat($etat);
                    }
                }
            }
            if ($sortie->getParticipantsInscrits()->count() < $sortie->getNbInscriptionMax() and $sortie->getEtat() != $etatEnCreation and $sortie->getDateLimiteInscription() > $dateDuJour) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Ouvert') {
                        $sortie->setEtat($etat);
                    }
                }
            }
            if ($dateFinSorties < $dateDuJour) {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Terminé') {
                        $sortie->setEtat($etat);

                    }
                }
            }
            if ($dateFinSorties < $dateUnMoisAvant) {

                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Historisé') {
                        $sortie->setEtat($etat);
                    }
                }
            }


            $this->entityManager->flush();

        }
    }
}

