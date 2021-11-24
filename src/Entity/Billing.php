<?php

namespace App\Entity;

use DateTime;
use App\Entity\Line;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BillingRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=BillingRepository::class)
 */
class Billing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $billing_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entitled;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $biling_status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $payment_deadline;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payment_method;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time_of_payment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @ORM\OneToOne(targetEntity=Project::class, mappedBy="billing", cascade={"persist", "remove"})
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity=Line::class, mappedBy="billing", cascade={"persist", "remove"})
     */
    private $lineList;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $customer_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $customer_id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="billings")
     */
    private $user;

    public function __construct()
    {
        $this->lineList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBillingNumber(): ?int
    {
        return $this->billing_number;
    }

    public function setBillingNumber(int $billing_number): self
    {
        $this->billing_number = $billing_number;

        return $this;
    }

    public function getEntitled(): ?string
    {
        return $this->entitled;
    }

    public function setEntitled(string $entitled): self
    {
        $this->entitled = $entitled;

        return $this;
    }

    public function getBilingStatus(): ?string
    {
        return $this->biling_status;
    }

    public function setBilingStatus(string $biling_status): self
    {
        $this->biling_status = $biling_status;

        return $this;
    }

    public function getCreationDate(): ?DateTime
    {
        return $this->creation_date;
    }

    public function setCreationDate(DateTime $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getPaymentDeadline(): ?DateTime
    {
        return $this->payment_deadline;
    }

    public function setPaymentDeadline(DateTime $payment_deadline): self
    {
        $this->payment_deadline = $payment_deadline;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getTimeOfPayment(): ?DateTime
    {
        return $this->time_of_payment;
    }

    public function setTimeOfPayment(DateTime $time_of_payment): self
    {
        $this->time_of_payment = $time_of_payment;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        // unset the owning side of the relation if necessary
        if ($project === null && $this->project !== null) {
            $this->project->setBilling(null);
        }

        // set the owning side of the relation if necessary
        if ($project !== null && $project->getBilling() !== $this) {
            $project->setBilling($this);
        }

        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Line[]
     */
    public function getLineList(): Collection
    {
        return $this->lineList;
    }

    public function addLineList(Line $lineList): self
    {
        if (!$this->lineList->contains($lineList)) {
            $this->lineList[] = $lineList;
            $lineList->setBilling($this);
        }

        return $this;
    }

    public function removeLineList(Line $lineList): self
    {
        if ($this->lineList->removeElement($lineList)) {
            // set the owning side to null (unless already changed)
            if ($lineList->getBilling() === $this) {
                $lineList->setBilling(null);
            }
        }

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function setCustomerName(string $customer_name): self
    {
        $this->customer_name = $customer_name;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(?int $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

}
