<?php

namespace App\Form\Model;

use App\Entity\Campus;
use App\Entity\Participant;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class FiltresSortiesFormModel
{

    public Campus $campus;
    public String $recherche;
    public DateTime $dateDebut;
    public Date $dateFin;
    public bool $organisateur;
    public bool $inscrit;
    public bool $nonInscrit;
    public bool $sortiesPassées;

    /**
     * @return Campus
     */
    public function getCampus(): Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus $campus
     * @return FiltresSortiesFormModel
     */
    public function setCampus(Campus $campus): FiltresSortiesFormModel
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return String
     */
    public function getRecherche(): string
    {
        return $this->recherche;
    }

    /**
     * @param String $recherche
     * @return FiltresSortiesFormModel
     */
    public function setRecherche(string $recherche): FiltresSortiesFormModel
    {
        $this->recherche = $recherche;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateDebut(): DateTime
    {
        return $this->dateDebut;
    }

    /**
     * @param DateTime $dateDebut
     * @return FiltresSortiesFormModel
     */
    public function setDateDebut(DateTime $dateDebut): FiltresSortiesFormModel
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * @return Date
     */
    public function getDateFin(): Date
    {
        return $this->dateFin;
    }

    /**
     * @param Date $dateFin
     * @return FiltresSortiesFormModel
     */
    public function setDateFin(Date $dateFin): FiltresSortiesFormModel
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOrganisateur(): bool
    {
        return $this->organisateur;
    }

    /**
     * @param bool $organisateur
     * @return FiltresSortiesFormModel
     */
    public function setOrganisateur(bool $organisateur): FiltresSortiesFormModel
    {
        $this->organisateur = $organisateur;
        return $this;
    }

    /**
     * @return bool
     */
    public function isInscrit(): bool
    {
        return $this->inscrit;
    }

    /**
     * @param bool $inscrit
     * @return FiltresSortiesFormModel
     */
    public function setInscrit(bool $inscrit): FiltresSortiesFormModel
    {
        $this->inscrit = $inscrit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNonInscrit(): bool
    {
        return $this->nonInscrit;
    }

    /**
     * @param bool $nonInscrit
     * @return FiltresSortiesFormModel
     */
    public function setNonInscrit(bool $nonInscrit): FiltresSortiesFormModel
    {
        $this->nonInscrit = $nonInscrit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortiesPassées(): bool
    {
        return $this->sortiesPassées;
    }

    /**
     * @param bool $sortiesPassées
     * @return FiltresSortiesFormModel
     */
    public function setSortiesPassées(bool $sortiesPassées): FiltresSortiesFormModel
    {
        $this->sortiesPassées = $sortiesPassées;
        return $this;
    }





}