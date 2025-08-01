<?php

namespace App\Entity;

use App\Repository\PlanningEntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanningEntryRepository::class)]
class PlanningEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $is_absent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'planningEntry')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'planningEntry')]
    private ?Shift $shift = null;

    #[ORM\ManyToOne(inversedBy: 'planningEntry')]
    private ?AbsenceType $absenceType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAbsent(): ?bool
    {
        return $this->is_absent;
    }

    public function setIsAbsent(bool $is_absent): static
    {
        $this->is_absent = $is_absent;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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

    public function getShift(): ?Shift
    {
        return $this->shift;
    }

    public function setShift(?Shift $shift): static
    {
        $this->shift = $shift;

        return $this;
    }

    public function getAbsenceType(): ?AbsenceType
    {
        return $this->absenceType;
    }

    public function setAbsenceType(?AbsenceType $absenceType): static
    {
        $this->absenceType = $absenceType;

        return $this;
    }
}
