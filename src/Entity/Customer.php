<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $laste_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activity_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity=Project::class, mappedBy="customer", cascade={"persist", "remove"})
     */
    private $projects;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLasteName(): ?string
    {
        return $this->laste_name;
    }

    public function setLasteName(string $laste_name): self
    {
        $this->laste_name = $laste_name;

        return $this;
    }

    public function getActivityType(): ?string
    {
        return $this->activity_type;
    }

    public function setActivityType(string $activity_type): self
    {
        $this->activity_type = $activity_type;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getprojects(): ?Project
    {
        return $this->projects;
    }

    public function setprojects(?Project $projects): self
    {
        // unset the owning side of the relation if necessary
        if ($projects === null && $this->projects !== null) {
            $this->projects->setCustomer(null);
        }

        // set the owning side of the relation if necessary
        if ($projects !== null && $projects->getCustomer() !== $this) {
            $projects->setCustomer($this);
        }

        $this->projects = $projects;

        return $this;
    }
}
