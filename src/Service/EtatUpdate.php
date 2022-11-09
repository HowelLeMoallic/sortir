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

        $dateDuJour = new \DateTime('now');



        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {

            $dateFinSorties = clone $sortie->getDateHeureDebut();
            $dateFinSorties->modify('+' . $sortie->getDuree() . ' minutes');


            if ($sortie->getEtat()->getLibelle() != 'Annulé') {

                if ($sortie->getDateHeureDebut() < $dateDuJour and $dateFinSorties > $dateDuJour) {

                    foreach ($etats as $etat) {

                        if ($etat->getLibelle() == 'En cours') {
                            $sortie->setEtat($etat);

                        }
                    }
                }
            }
            if (($sortie->getParticipantsInscrits()->count() == $sortie->getNbInscriptionMax() || $sortie->getDateLimiteInscription() < $dateDuJour) and $sortie->getEtat()->getlibelle() != 'Terminé') {
                foreach ($etats as $etat) {
                    if ($etat->getLibelle() == 'Fermé') {
                        $sortie->setEtat($etat);
                    }
                }
            }
            if ($sortie->getParticipantsInscrits()->count() < $sortie->getNbInscriptionMax() and $sortie->getEtat()->getLibelle() != 'En création' and $sortie->getDateLimiteInscription() > $dateDuJour) {
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

