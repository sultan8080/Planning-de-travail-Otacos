<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PlanningRepository::class)]
class Planning
{

    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $week_number = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $start_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $end_date = null;

    #[ORM\ManyToOne(inversedBy: 'planning')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Branch $branch = null;

    #[ORM\ManyToOne(inversedBy: 'planning')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    /**
     * @var Collection<int, Shift>
     */
    #[ORM\ManyToMany(targetEntity: Shift::class, mappedBy: 'planning')]
    private Collection $shifts;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'planning')]
    private Collection $note;

    public function __construct()
    {
        $this->shifts = new ArrayCollection();
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekNumber(): ?int
    {
        return $this->week_number;
    }

    public function setWeekNumber(int $week_number): static
    {
        $this->week_number = $week_number;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeImmutable $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeImmutable $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    public function setBranch(?Branch $branch): static
    {
        $this->branch = $branch;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Shift>
     */
    public function getShifts(): Collection
    {
        return $this->shifts;
    }

    public function addShift(Shift $shift): static
    {
        if (!$this->shifts->contains($shift)) {
            $this->shifts->add($shift);
            $shift->addPlanning($this);
        }

        return $this;
    }

    public function removeShift(Shift $shift): static
    {
        if ($this->shifts->removeElement($shift)) {
            $shift->removePlanning($this);
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
            $note->setPlanning($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getPlanning() === $this) {
                $note->setPlanning(null);
            }
        }

        return $this;
    }

}
