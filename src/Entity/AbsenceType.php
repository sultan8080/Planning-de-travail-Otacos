<?php

namespace App\Entity;

use App\Repository\AbsenceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbsenceTypeRepository::class)]
class AbsenceType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, PlanningEntry>
     */
    #[ORM\OneToMany(targetEntity: PlanningEntry::class, mappedBy: 'absenceType')]
    private Collection $planningEntry;

    public function __construct()
    {
        $this->planningEntry = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

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
            $planningEntry->setAbsenceType($this);
        }

        return $this;
    }

    public function removePlanningEntry(PlanningEntry $planningEntry): static
    {
        if ($this->planningEntry->removeElement($planningEntry)) {
            // set the owning side to null (unless already changed)
            if ($planningEntry->getAbsenceType() === $this) {
                $planningEntry->setAbsenceType(null);
            }
        }

        return $this;
    }
}
