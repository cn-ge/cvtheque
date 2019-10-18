<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email")
 * @ORM\Entity()
 */
class User implements UserInterface, \Serializable {

    const CIVILITE = [
        0 => 'Monsieur',
        1 => 'Madame',
        2 => 'Mademoiselle'
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=250)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $civilite = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Assert\Regex("/^[0-9]{10}$/")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $adresse_1;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $adresse_2;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $poste_recherche;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $statut;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default": false})
     */
    private $mobilite;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(min=5, max=120)
     */
    private $mobilite_zone;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     * @Assert\Length(min=10)
     */
    private $notes;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formation", mappedBy="candidat", cascade={"persist"})
     */
    private $formations;


    public function __construct() {
        $this->date_creation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $this->formations = new ArrayCollection();
        $this->isActive = true;
    }


    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }
    
    public function getRoles() {
        return $this->roles;
    }

    function getPlainPassword() {
        return $this->plainPassword;
    }

    function getIsActive() {
        return $this->isActive;
    }

    public function getUsername() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    function addRole($role) {
        $this->roles[] = $role;
    }

    function removeRoles() {
        foreach($this->roles as $k=>$role) {
            unset($this->roles[$k]);
        }
    }

    public function eraseCredentials() {
       
    }
    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->isActive,
                // see section on salt below
                // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->email,
                $this->password,
                $this->isActive,
                ) = unserialize($serialized);
    }


    public function getCivilite(): ?int
    {
        return $this->civilite;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function getPosteRecherche(): ?string
    {
        return $this->poste_recherche;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function getMobilite(): ?bool
    {
        return $this->mobilite;
    }

    public function getMobiliteZone(): ?string
    {
        return $this->mobilite_zone;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse_1;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse_2;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }


    function setId($id) {
        $this->id = $id;
    }

    public function setEmail(string $email): self
    {
        $this->email = strtolower(trim($email));
        return $this;
    }

    function setPlainPassword($plainPassword) {
        $this->plainPassword = $plainPassword;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setIsActive($isActive) {
        $this->isActive = $isActive;
    }


    public function setCivilite(int $civilite): self
    {
        $this->civilite = $civilite;
        return $this;
    }

    public function setNom(string $nom): self
    {
        $nom = str_ireplace('-', ' ', $nom);
        $nom = str_ireplace('  ', ' ', $nom);
        $this->nom = strtoupper(trim($nom));
        return $this;
    }

    public function setPrenom(string $prenom): self
    {
        $prenom = str_ireplace('-', ' ', $prenom);
        $prenom = str_ireplace('  ', ' ', $prenom);
        $prenom = ucwords(strtolower(trim($prenom)));
        $this->prenom = str_ireplace(' ', '-', $prenom);
        return $this;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = trim($telephone);
        return $this;
    }

    public function setAdresse1(string $adresse_1): self
    {
        $this->adresse_1 = trim($adresse_1);
        return $this;
    }

    public function setAdresse2(string $adresse_2): self
    {
        $this->adresse_2 = trim($adresse_2);
        return $this;
    }

    public function setCp(string $cp): self
    {
        $this->cp = trim($cp);
        return $this;
    }
    
    public function setVille(string $ville): self
    {
        $this->ville = mb_strtoupper(trim($ville));
        return $this;
    }
    
    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;
        return $this;
    }

    public function setMobilite(bool $mobilite): self
    {
        $this->mobilite = $mobilite;
        return $this;
    }

    public function setMobiliteZone(string $mobilite_zone): self
    {
        $this->mobilite_zone = trim($mobilite_zone);
        return $this;
    }

    public function setNotes(string $notes): self
    {
        $this->notes = trim($notes);
        return $this;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = mb_strtoupper(trim($statut));
        return $this;
    }

    public function setPosteRecherche(string $poste_recherche): self
    {
        $this->poste_recherche = mb_strtoupper(trim($poste_recherche));
        return $this;
    }
    public function getSlug(): string {
        $slug = new Slugify();
        return $slug->slugify($this->nom . ' ' . $this->prenom);
    }

    public function getFormattedDateCreation() : string {
        return date_format($this->date_creation, 'd/m/Y H:i');
    }

    public function getFormattedCivilite(): ?string
    {
        return self::CIVILITE[$this->getCivilite()];
    }

    public function getFormattedDateNaissance() : string {
        return date_format($this->date_naissance, 'd/m/Y H:i');
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

    /**
     * @return Collection|Formation[]
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations[] = $formation;
            $formation->setCandidat($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->contains($formation)) {
            $this->formations->removeElement($formation);
            // set the owning side to null (unless already changed)
            if ($formation->getCandidat() === $this) {
                $formation->setCandidat(null);
            }
        }
        return $this;
    }
}