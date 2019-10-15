<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CandidatRepository")
 */
class Candidat
{


    const CIVILITE = [
        0 => 'Monsieur',
        1 => 'Madame',
        2 => 'Mademoiselle'
    ];


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Regex("/^[0-9]{10}$/")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=120, unique=true)
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide.",
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $civilite = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\Length(min=5, max=120)
     */
    private $poste_vise;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\Length(min=5, max=120)
     */
    private $titre;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $mobilite;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $mobilite_zone;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\Length(min=5, max=120)
     */
    private $adresse_1;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $adresse_2;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     * @Assert\Length(min=10)
     */
    private $notes;


    private $formations;

    function __construct()
    {
        $this->date_creation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $nom = str_ireplace('-', ' ', $nom);
        $nom = str_ireplace('  ', ' ', $nom);
        $this->nom = strtoupper(trim($nom));

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $prenom = str_ireplace('-', ' ', $prenom);
        $prenom = str_ireplace('  ', ' ', $prenom);
        $this->prenom = ucwords(strtolower(trim($prenom)));
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = trim($telephone);
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = strtolower(trim($email));
        return $this;
    }

    public function getCivilite(): ?int
    {
        return $this->civilite;
    }

    public function getFormattedCivilite(): ?string
    {
        return self::CIVILITE[$this->getCivilite()];
    }

    public function setCivilite(int $civilite): self
    {
        $this->civilite = $civilite;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function getFormattedDateCreation() : string {
        return date_format($this->date_creation, 'd/m/Y H:i');
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;
        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = strtoupper(trim($ville));
        return $this;
    }

    public function getPosteVise(): ?string
    {
        return $this->poste_vise;
    }

    public function setPosteVise(string $poste_vise): self
    {
        $this->poste_vise = mb_strtoupper(trim($poste_vise));
        return $this;
    }

    public function getSlug(): string {
        $slug = new Slugify();
        return $slug->slugify($this->nom . ' ' . $this->prenom);
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function getFormattedDateNaissance() : string {
        return date_format($this->date_naissance, 'd/m/Y H:i');
    }
    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;
        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = trim($titre);
        return $this;
    }

    public function getMobilite(): ?bool
    {
        return $this->mobilite;
    }

    public function setMobilite(bool $mobilite): self
    {
        $this->mobilite = $mobilite;
        return $this;
    }

    public function getMobiliteZone(): ?string
    {
        return $this->mobilite_zone;
    }

    public function setMobiliteZone(string $mobilite_zone): self
    {
        $this->mobilite_zone = $mobilite_zone;
        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse_1;
    }

    public function setAdresse1(string $adresse_1): self
    {
        $this->adresse_1 = $adresse_1;
        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse_2;
    }

    public function setAdresse2(string $adresse_2): self
    {
        $this->adresse_2 = $adresse_2;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getAge(): ?string
    {
        $now = new \Datetime('now');
        return $now->diff($this->date_naissance)->format("%Y");
    }

    public function getFirstLetter(): ?string
    {
        return substr($this->nom, 0, 1) . '.';
    }

    public function getFormations(): ?array {
        $formations = $this->getDoctrine()
        ->getRepository(Formation::class)
        ->findByCandidat($this->id);
    }
}
