<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\TimestampableTrait;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface

{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Branch $branch = null;

    /**
     * @var Collection<int, PlanningEntry>
     */
    #[ORM\OneToMany(targetEntity: PlanningEntry::class, mappedBy: 'user')]
    private Collection $planningEntry;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'user')]
    private Collection $note;

    /**
     * @var Collection<int, Planning>
     */
    #[ORM\OneToMany(targetEntity: Planning::class, mappedBy: 'user')]
    private Collection $planning;

    public function __construct()
    {
        $this->planningEntry = new ArrayCollection();
        $this->note = new ArrayCollection();
        $this->planning = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = 'ROLE_EMPLOYEE';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
    }

    use TimestampableTrait;

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): static
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * @return Collection<int, PlanningEntry>
     */
    public function getPlanningEntry(): Collection
    {
        return $this->planningEntry;
    }

    public function addPlanningEntry(PlanningEntry $planningEntry): static
    {
        if (!$this->planningEntry->contains($planningEntry)) {
            $this->planningEntry->add($planningEntry);
            $planningEntry->setUser($this);
        }

        return $this;
    }

    public function removePlanningEntry(PlanningEntry $planningEntry): static
    {
        if ($this->planningEntry->removeElement($planningEntry)) {
            // set the owning side to null (unless already changed)
            if ($planningEntry->getUser() === $this) {
                $planningEntry->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(Note $note): static
    {
        if (!$this->note->contains($note)) {
            $this->note->add($note);
            $note->setUser($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getUser() === $this) {
                $note->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlanning(): Collection
    {
        return $this->planning;
    }

    public function addPlanning(Planning $planning): static
    {
        if (!$this->planning->contains($planning)) {
            $this->planning->add($planning);
            $planning->setUser($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): static
    {
        if ($this->planning->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getUser() === $this) {
                $planning->setUser(null);
            }
        }

        return $this;
    }
}
