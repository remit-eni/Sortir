<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints\Date;


class SortiesSearch
{

    /**
     * @var string|null
     */
    private $campus;

    /**
     * @var string|null
     */
    private $keyword;

    /**
     * @var date()
     */
    private $dateDebut;

    /**
     * @var date()
     */
    private $dateFin;

    /**
     * @var boolean|null
     */
    private $isOrganisateur;

    /**
     * @var boolean|null
     */
    private $isInscrit;

    /**
     * @var boolean|null
     */
    private $isNotInscrit;

    /**
     * @var boolean|null
     */
    private $isFinished;

    /**
     * @return mixed
     */
    public function getCampus()
    {
        return $this->campus;
    }

    /**
     * @param mixed $campus
     */
    public function setCampus($campus): void
    {
        $this->campus = $campus;
    }

    /**
     * @return string|null
     */
    public function getKeyword(): ?string
    {
        return $this->keyword;
    }

    /**
     * @param string|null $keyword
     */
    public function setKeyword(?string $keyword): void
    {
        $this->keyword = $keyword;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin): void
    {
        $this->dateFin = $dateFin;
    }


    /**
     * @return bool|null
     */
    public function getIsOrganisateur(): ?bool
    {
        return $this->isOrganisateur;
    }

    /**
     * @param bool|null $isOrganisateur
     */
    public function setIsOrganisateur(?bool $isOrganisateur): void
    {
        $this->isOrganisateur = $isOrganisateur;
    }

    /**
     * @return bool|null
     */
    public function getIsInscrit(): ?bool
    {
        return $this->isInscrit;
    }

    /**
     * @param bool|null $isInscrit
     */
    public function setIsInscrit(?bool $isInscrit): void
    {
        $this->isInscrit = $isInscrit;
    }

    /**
     * @return bool|null
     */
    public function getIsNotInscrit(): ?bool
    {
        return $this->isNotInscrit;
    }

    /**
     * @param bool|null $isNotInscrit
     */
    public function setIsNotInscrit(?bool $isNotInscrit): void
    {
        $this->isNotInscrit = $isNotInscrit;
    }

    /**
     * @return bool|null
     */
    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    /**
     * @param bool|null $isFinished
     */
    public function setIsFinished(?bool $isFinished): void
    {
        $this->isFinished = $isFinished;
    }

}

