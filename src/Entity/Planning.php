<?php

namespace App\Entity;

use App\Repository\PlanningRepository;
use App\Entity\Traits\TimestampableTrait;
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

}
