<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatRepository::class)
 */
class Etat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string" length=255)
     */
    private $libelle;

    /**
     * ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="sortie")
     */
    private $sortie;




}
