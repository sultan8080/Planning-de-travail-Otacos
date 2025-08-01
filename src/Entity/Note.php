<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
  use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'note')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'note')]
    private ?Planning $planning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

  use TimestampableTrait;

  public function getUser(): ?User
  {
      return $this->user;
  }

  public function setUser(?User $user): static
  {
      $this->user = $user;

      return $this;
  }

  public function getPlanning(): ?Planning
  {
      return $this->planning;
  }

  public function setPlanning(?Planning $planning): static
  {
      $this->planning = $planning;

      return $this;
  }
}
