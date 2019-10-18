<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationRepository")
 */
class Formation
{
    const NIVEAU = [
            0 => 'Bac+5',
            1 => 'Bac+4',
            2 => 'Bac+3',
            3 => 'Bac+2',
            4 => 'Bac',
            5 => 'Autres'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="formations",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $candidat;
    
    /**
     * @ORM\Column(type="string", length=4)
     * @Assert\Regex("/^[0-9]{4}$/")
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $diplome;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $obtenu;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ecole;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $alternance;

    /**
     * @ORM\Column(type="integer", options={"default": 5})
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidat(): ?User
    {
        return $this->candidat;
    }

    public function setCandidat(?User $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): self
    {
        $this->diplome = strtoupper(trim($diplome));

        return $this;
    }

    public function getObtenu(): ?bool
    {
        return $this->obtenu;
    }

    public function setObtenu(bool $obtenu): self
    {
        $this->obtenu = $obtenu;

        return $this;
    }

    public function getEcole(): ?string
    {
        return $this->ecole;
    }

    public function setEcole(string $ecole): self
    {
        $this->ecole = strtoupper(trim($ecole));

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = strtoupper(trim($ville));

        return $this;
    }

    public function getAlternance(): ?bool
    {
        return $this->alternance;
    }

    public function setAlternance(bool $alternance): self
    {
        $this->alternance = $alternance;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): self
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getFormattedNiveau(): ?string
    {
        return self::NIVEAU[$this->niveau];
    }
}
