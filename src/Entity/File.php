<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[ORM\Table(name: '`user__file`')]
class File
{
	#[ORM\Id]
	#[ORM\Column(type: "uuid", unique: true)]
	#[ORM\GeneratedValue(strategy: "CUSTOM")]
	#[ORM\CustomIdGenerator(class: UuidGenerator::class)]
	protected UuidInterface|string $id;

    #[ORM\Column(length: 255)]
    private ?string $originalName = null;

    #[ORM\Column(length: 255)]
    private ?string $clearName = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\OneToOne(inversedBy: 'file', cascade: ['persist', 'remove'])]
    private ?User $owner = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(string $originalName): static
    {
        $this->originalName = $originalName;

        return $this;
    }

    public function getClearName(): ?string
    {
        return $this->clearName;
    }

    public function setClearName(string $clearName): static
    {
        $this->clearName = $clearName;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
