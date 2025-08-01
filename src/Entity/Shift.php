<?php

namespace App\Entity;

use App\Repository\ShiftRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShiftRepository::class)]
class Shift
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $start_time = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $end_time = null;

    #[ORM\ManyToOne(inversedBy: 'shift')]
    private ?ShiftType $shiftType = null;

    /**
     * @var Collection<int, PlanningEntry>
     */
    #[ORM\OneToMany(targetEntity: PlanningEntry::class, mappedBy: 'shift')]
    private Collection $planningEntry;

    /**
     * @var Collection<int, Planning>
     */
    #[ORM\ManyToMany(targetEntity: Planning::class, inversedBy: 'shifts')]
    private Collection $planning;

    public function __construct()
    {
        $this->planningEntry = new ArrayCollection();
        $this->planning = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeImmutable $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeImmutable $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getShiftType(): ?ShiftType
    {
        return $this->shiftType;
    }

    public function setShiftType(?ShiftType $shiftType): static
    {
        $this->shiftType = $shiftType;

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
            $planningEntry->setShift($this);
        }

        return $this;
    }

    public function removePlanningEntry(PlanningEntry $planningEntry): static
    {
        if ($this->planningEntry->removeElement($planningEntry)) {
            // set the owning side to null (unless already changed)
            if ($planningEntry->getShift() === $this) {
                $planningEntry->setShift(null);
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
        }

        return $this;
    }

    public function removePlanning(Planning $planning): static
    {
        $this->planning->removeElement($planning);

        return $this;
    }
}
