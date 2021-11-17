<?php

namespace App\Entity;

use App\Repository\BillingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=255)
     */
    private $creation_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payment_deadline;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payment_method;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $time_of_payment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity=line::class, mappedBy="lines")
     */
    private $billing_line_id;

    public function __construct()
    {
        $this->billing_line_id = new ArrayCollection();
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

    public function getCreationDate(): ?string
    {
        return $this->creation_date;
    }

    public function setCreationDate(string $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getPaymentDeadline(): ?string
    {
        return $this->payment_deadline;
    }

    public function setPaymentDeadline(string $payment_deadline): self
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

    public function getTimeOfPayment(): ?string
    {
        return $this->time_of_payment;
    }

    public function setTimeOfPayment(string $time_of_payment): self
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

    /**
     * @return Collection|line[]
     */
    public function getBillingLineId(): Collection
    {
        return $this->billing_line_id;
    }

    public function addBillingLineId(line $billingLineId): self
    {
        if (!$this->billing_line_id->contains($billingLineId)) {
            $this->billing_line_id[] = $billingLineId;
            $billingLineId->setLines($this);
        }

        return $this;
    }

    public function removeBillingLineId(line $billingLineId): self
    {
        if ($this->billing_line_id->removeElement($billingLineId)) {
            // set the owning side to null (unless already changed)
            if ($billingLineId->getLines() === $this) {
                $billingLineId->setLines(null);
            }
        }

        return $this;
    }
}