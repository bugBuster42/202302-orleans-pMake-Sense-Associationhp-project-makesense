<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?Decision $decision = null;

    #[ORM\ManyToOne(inversedBy: 'votes')]
    private ?User $user = null;

    #[ORM\Column]
    private ?int $voting = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDecision(): ?Decision
    {
        return $this->decision;
    }

    public function setDecision(?Decision $decision): static
    {
        $this->decision = $decision;

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

    public function getVoting(): ?int
    {
        return $this->voting;
    }

    public function setVoting(int $voting): static
    {
        $this->voting = $voting;

        return $this;
    }
}
