<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JobOfferRepository::class)]
#[ORM\Table(name: '`job__offer`')]
class JobOffer
{
	#[ORM\Id]
	#[ORM\Column(type: "uuid", unique: true)]
	#[ORM\GeneratedValue(strategy: "CUSTOM")]
	#[ORM\CustomIdGenerator(class: UuidGenerator::class)]
	protected UuidInterface|string $id;

	#[Assert\Length(
		min: 5,
		minMessage: 'Tytuł musi posiadać co namiej {{ limit }} znaków'
	)]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

	#[Assert\Length(
		min: 10,
		minMessage: 'Opis musi posiadać co namiej {{ limit }} znaków'
	)]
    #[ORM\Column(length: 2500)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'jobApplication')]
    private Collection $jobApplication;

    public function __construct()
    {
		$this->createdAt = new \DateTimeImmutable();
        $this->jobApplication = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getJobApplication(): Collection
    {
        return $this->jobApplication;
    }

    public function addJobApplication(User $jobApplication): static
    {
        if (!$this->jobApplication->contains($jobApplication)) {
            $this->jobApplication->add($jobApplication);
            $jobApplication->addJobApplication($this);
        }

        return $this;
    }

    public function removeJobApplication(User $jobApplication): static
    {
        if ($this->jobApplication->removeElement($jobApplication)) {
            $jobApplication->removeJobApplication($this);
        }

        return $this;
    }
}
