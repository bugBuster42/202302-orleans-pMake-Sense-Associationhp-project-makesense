<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use App\Repository\DecisionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DecisionRepository::class)]
class Decision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan('today')]
    #[Assert\NotNull]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'decisions')]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'decisions')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'decision', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'decisions')]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'expertUsers')]
    #[JoinTable('expert_user')]
    private Collection $expertUsers;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'impactedUsers')]
    #[JoinTable('impacted_user')]
    private Collection $impactedUsers;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->expertUsers = new ArrayCollection();
        $this->impactedUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setDecision($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getDecision() === $this) {
                $comment->setDecision(null);
            }
        }
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
     * @return Collection<int, User>
     */
    public function getExpertUsers(): Collection
    {
        return $this->expertUsers;
    }

    public function addExpertUser(User $expertUser): static
    {
        if (!$this->expertUsers->contains($expertUser)) {
            $this->expertUsers->add($expertUser);
        }

        return $this;
    }

    public function removeExpertUser(User $expertUser): static
    {
        $this->expertUsers->removeElement($expertUser);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getImpactedUsers(): Collection
    {
        return $this->impactedUsers;
    }

    public function addImpactedUser(User $impactedUser): static
    {
        if (!$this->impactedUsers->contains($impactedUser)) {
            $this->impactedUsers->add($impactedUser);
        }

        return $this;
    }

    public function removeImpactedUser(User $impactedUser): static
    {
        $this->impactedUsers->removeElement($impactedUser);

        return $this;
    }
}
