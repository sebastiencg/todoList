<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column]
    private ?bool $statu = null;

    #[ORM\ManyToOne(inversedBy: 'todos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $author = null;

    #[ORM\ManyToMany(targetEntity: Profile::class, inversedBy: 'todos')]
    private Collection $invite;

    public function __construct()
    {
        $this->invite = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isStatu(): ?bool
    {
        return $this->statu;
    }

    public function setStatu(bool $statu): self
    {
        $this->statu = $statu;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */

    public function getAuthor(): ?Profile
    {
        return $this->author;
    }

    public function setAuthor(?Profile $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getInvite(): Collection
    {
        return $this->invite;
    }

    public function addInvite(Profile $invite): self
    {
        if (!$this->invite->contains($invite)) {
            $this->invite->add($invite);
        }

        return $this;
    }

    public function removeInvite(Profile $invite): self
    {
        $this->invite->removeElement($invite);

        return $this;
    }


}
