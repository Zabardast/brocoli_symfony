<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\EqualTo(propertyPath="check_password", message="the passwords do not match")
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $password;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\EqualTo(propertyPath="password", message="the passwords do not match")
     */
    private $check_password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $Date_of_birth;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $phone_number;

    /**
     * @ORM\Column(type="float")
     * @Assert\PositiveOrZero(message="this value must be more than or equal to 0")
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $turne_over;

    /**
     * @ORM\Column(type="float")
     * @Assert\PositiveOrZero(message="this value must be more than or equal to 0")
     * @Assert\NotNull(message="field is required for account creation")
     */
    private $taxed_income;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="user")
     */
    private $customer;

    public function __construct()
    {
        $this->billing = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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
        $roles[] = 'ROLE_MEMBER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
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

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

        /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getCheckPassword(): string
    {
        return $this->check_password;
    }

    public function setCheckPassword(string $t_password): self
    {
        $this->check_password = $t_password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->Date_of_birth;
    }

    public function setDateOfBirth(\DateTime $Date_of_birth): self
    {
        $this->Date_of_birth = $Date_of_birth;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getTurneOver(): ?float
    {
        return $this->turne_over;
    }

    public function setTurneOver(float $turne_over): self
    {
        $this->turne_over = $turne_over;

        return $this;
    }

    public function getTaxedIncome(): ?float
    {
        return $this->taxed_income;
    }

    public function setTaxedIncome(float $taxed_income): self
    {
        $this->taxed_income = $taxed_income;

        return $this;
    }

    /**
     * @return Collection|Billing[]
     */
    public function getBilling(): Collection
    {
        return $this->billing;
    }

    public function addBilling(Billing $billing): self
    {
        if (!$this->billing->contains($billing)) {
            $this->billing[] = $billing;
            $billing->setUser($this);
        }

        return $this;
    }

    public function removeBilling(Billing $billing): self
    {
        if ($this->billing->removeElement($billing)) {
            // set the owning side to null (unless already changed)
            if ($billing->getUser() === $this) {
                $billing->setUser(null);
            }
        }

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
