<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user__user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected UuidInterface|string $id;

	#[Assert\Email(
    	message: 'Podany emial "{{ value }}" jest nieprawidłowy.',
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
	#[Assert\PasswordStrength([
                        		'minScore' => PasswordStrength::STRENGTH_MEDIUM,
                        	])]
                            #[ORM\Column]
                            private ?string $password = null;

	#[Assert\Length(
                        		min: 3,
                        		minMessage: 'Imię musi posiadać mnie co namiej {{ limit }} znaki'
                        	)]
                            #[ORM\Column(length: 50)]
                            private ?string $firstName = null;

	#[Assert\Length(
                        		min: 3,
                        		minMessage: 'Nazwisko musi posiadać mnie co namiej {{ limit }} znaki'
                        	)]
                            #[ORM\Column(length: 50)]
                            private ?string $lastName = null;

	#[Assert\Regex(
                        		pattern: '/^([0-9]{9,14})$/',
                        		message: 'Błędny numer telefonu',
                        	)]
                            #[ORM\Column(length: 255)]
                            private ?string $phone = null;

	#[Assert\Length(
                        		min: 4,
                        		minMessage: 'Adres musi posiadać mnie co namiej {{ limit }} znaki'
                        	)]
                            #[ORM\Column(length: 255)]
                            private ?string $address = null;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?File $file = null;

    #[ORM\ManyToMany(targetEntity: JobOffer::class, inversedBy: 'jobApplication')]
    #[ORM\JoinTable(name: 'job__application')]
    private Collection $jobApplication;

    public function __construct()
    {
        $this->jobApplication = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        // unset the owning side of the relation if necessary
        if ($file === null && $this->file !== null) {
            $this->file->setOwner(null);
        }

        // set the owning side of the relation if necessary
        if ($file !== null && $file->getOwner() !== $this) {
            $file->setOwner($this);
        }

        $this->file = $file;

        return $this;
    }

    /**
     * @return Collection<int, JobOffer>
     */
    public function getJobApplication(): Collection
    {
        return $this->jobApplication;
    }

    public function addJobApplication(JobOffer $jobApplication): static
    {
        if (!$this->jobApplication->contains($jobApplication)) {
            $this->jobApplication->add($jobApplication);
        }

        return $this;
    }

    public function removeJobApplication(JobOffer $jobApplication): static
    {
        $this->jobApplication->removeElement($jobApplication);

        return $this;
    }
}
