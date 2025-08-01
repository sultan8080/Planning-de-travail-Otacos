<?php

namespace App\Entity;

use App\Repository\ShiftTypeRepository;
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
}
