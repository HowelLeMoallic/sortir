<?php

namespace App\Form\Model;

use App\Entity\Campus;
use App\Entity\Sortie;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\Validator\Constraints as Assert;


class FiltresSortiesFormModel
{

//    #[Assert\Choice(choices: [Campus::class, 'getNom'])]
    private ?Campus $campus  = null;

    private ?string $recherche = null;

    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeInterface $dateDebut = null;


    #[Assert\GreaterThan(propertyPath: "dateDebut", message: 'La date de fin doit être supérieur à la date de début')]
    private ?\DateTimeInterface $dateFin = null;
    private ?bool $organisateur = null;
    private ?bool $inscrit = null;
    private ?bool $nonInscrit = null;
    private ?bool $sortiesPassees = null;

    /**
     * @return Campus|null
     */
    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus|null $campus
     * @return FiltresSortiesFormModel
     */
    public function setCampus(?Campus $campus): FiltresSortiesFormModel
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return String|null
     */
    public function getRecherche(): ?string
    {
        return $this->recherche;
    }

    /**
     * @param String|null $recherche
     * @return FiltresSortiesFormModel
     */
    public function setRecherche(?string $recherche): FiltresSortiesFormModel
    {
        $this->recherche = $recherche;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTimeInterface|null $dateDebut
     * @return FiltresSortiesFormModel
     */
    public function setDateDebut(?\DateTimeInterface $dateDebut): FiltresSortiesFormModel
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTimeInterface|null $dateFin
     * @return FiltresSortiesFormModel
     */
    public function setDateFin(?\DateTimeInterface $dateFin): FiltresSortiesFormModel
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOrganisateur(): ?bool
    {
        return $this->organisateur;
    }

    /**
     * @param bool|null $organisateur
     * @return FiltresSortiesFormModel
     */
    public function setOrganisateur(?bool $organisateur): FiltresSortiesFormModel
    {
        $this->organisateur = $organisateur;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getInscrit(): ?bool
    {
        return $this->inscrit;
    }

    /**
     * @param bool|null $inscrit
     * @return FiltresSortiesFormModel
     */
    public function setInscrit(?bool $inscrit): FiltresSortiesFormModel
    {
        $this->inscrit = $inscrit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNonInscrit(): ?bool
    {
        return $this->nonInscrit;
    }

    /**
     * @param bool|null $nonInscrit
     * @return FiltresSortiesFormModel
     */
    public function setNonInscrit(?bool $nonInscrit): FiltresSortiesFormModel
    {
        $this->nonInscrit = $nonInscrit;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSortiesPassees(): ?bool
    {
        return $this->sortiesPassees;
    }

    /**
     * @param bool|null $sortiesPassees
     * @return FiltresSortiesFormModel
     */
    public function setSortiesPassees(?bool $sortiesPassees): FiltresSortiesFormModel
    {
        $this->sortiesPassees = $sortiesPassees;
        return $this;
    }







}