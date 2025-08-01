<?php

namespace App\Entity;

use App\Repository\ShiftTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShiftTypeRepository::class)]
class ShiftType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $shift_name = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $default_start = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $default_end = null;

    /**
     * @var Collection<int, Shift>
     */
    #[ORM\OneToMany(targetEntity: Shift::class, mappedBy: 'shiftType')]
    private Collection $shift;

    public function __construct()
    {
        $this->shift = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShiftName(): ?string
    {
        return $this->shift_name;
    }

    public function setShiftName(string $shift_name): static
    {
        $this->shift_name = $shift_name;

        return $this;
    }

    public function getDefaultStart(): ?\DateTimeImmutable
    {
        return $this->default_start;
    }

    public function setDefaultStart(\DateTimeImmutable $default_start): static
    {
        $this->default_start = $default_start;

        return $this;
    }

    public function getDefaultEnd(): ?\DateTimeImmutable
    {
        return $this->default_end;
    }

    public function setDefaultEnd(\DateTimeImmutable $default_end): static
    {
        $this->default_end = $default_end;

        return $this;
    }

    /**
     * @return Collection<int, Shift>
     */
    public function getShift(): Collection
    {
        return $this->shift;
    }

    public function addShift(Shift $shift): static
    {
        if (!$this->shift->contains($shift)) {
            $this->shift->add($shift);
            $shift->setShiftType($this);
        }

        return $this;
    }

    public function removeShift(Shift $shift): static
    {
        if ($this->shift->removeElement($shift)) {
            // set the owning side to null (unless already changed)
            if ($shift->getShiftType() === $this) {
                $shift->setShiftType(null);
            }
        }

        return $this;
    }
}
