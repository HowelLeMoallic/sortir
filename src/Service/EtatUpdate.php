<?php

namespace App\Service;

use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;

class EtatUpdate
{
    public function checkedDate(SortieRepository $sortieRepository, EtatRepository $etatRepository, EntityManagerInterface $entityManager):void
    {
        $sorties = $sortieRepository->findAll();
        $etat = $etatRepository->findAll();
        $etatAnnuler = in_array('Annule', $etat) ;




        $dateDuJour = new \DateTime('now');

        $dateUnMoisAvant = new \DateTime('now');
        $dateUnMoisAvant->modify('-1 month');

        foreach ($sorties as $sortie) {


            if ($sortie->getDateHeureDebut() < $dateUnMoisAvant) {
                $sortie->setEtat();
            } elseif ($sortie->getEtat() != $etatAnnuler) {
                if ($sortie->getDateHeureDebut() == $dateDuJour){
                    $sortie->setEtat();
                }
                elseif ($sortie->getDateHeureDebut() < $dateDuJour) {
                    $sortie->setEtat();
                }
                elseif ($sortie->getParticipantsInscrits()->count() == $sortie->getNbInscriptionMax() || $sortie->getDateLimiteInscription() < $dateDuJour) {
                    $sortie->setEtat();
                } elseif ($sortie->getParticipantsInscrits()->count() < $sortie->getNbInscriptionMax()) {
                    $sortie->setEtat();
                }
            }




        }
        $entityManager->flush();




    }

}