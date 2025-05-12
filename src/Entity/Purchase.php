<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: \App\Repository\PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Please, enter your full name!')]
    private ?string $customerName = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Please, enter your email address!')]
    #[Assert\Email(message: 'Please, enter a valid email!')]
    private ?string $customerEmail = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Please, enter your street address!')]
    private ?string $customerAddress = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 20, nullable: true)]
    #[Assert\NotBlank(message: 'Please, enter your ZIP code!')]
    private ?string $customerZip = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[Assert\NotBlank(message: 'Please, enter your City!')]
    private ?string $customerCity = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 20, nullable: true)]
    #[Assert\NotBlank(message: 'Please, provide a phone number!')]
    private ?string $customerPhone = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::BOOLEAN)]
    private ?bool $isShipped = false;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, \App\Entity\PurchaseItem>
     */
    #[ORM\OneToMany(targetEntity: \App\Entity\PurchaseItem::class, mappedBy: 'purchase', orphanRemoval: true, cascade: ['persist'])]
    private \Doctrine\Common\Collections\Collection $purchaseItems;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->purchaseItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(string $customerEmail): self
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    public function getCustomerAddress(): ?string
    {
        return $this->customerAddress;
    }

    public function setCustomerAddress(string $customerAddress): self
    {
        $this->customerAddress = $customerAddress;

        return $this;
    }

    public function getCustomerZip(): ?string
    {
        return $this->customerZip;
    }

    public function setCustomerZip(?string $customerZip): self
    {
        $this->customerZip = $customerZip;

        return $this;
    }

    public function getCustomerCity(): ?string
    {
        return $this->customerCity;
    }

    public function setCustomerCity(string $customerCity): self
    {
        $this->customerCity = $customerCity;

        return $this;
    }

    public function getCustomerPhone(): ?string
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone(?string $customerPhone): self
    {
        $this->customerPhone = $customerPhone;

        return $this;
    }

    public function getIsShipped(): ?bool
    {
        return $this->isShipped;
    }

    public function setIsShipped(bool $isShipped): self
    {
        $this->isShipped = $isShipped;

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

    /**
     * @return Collection|PurchaseItem[]
     */
    public function getPurchaseItems(): Collection
    {
        return $this->purchaseItems;
    }

    public function addPurchaseItem(PurchaseItem $purchaseItem): self
    {
        if (!$this->purchaseItems->contains($purchaseItem)) {
            $this->purchaseItems[] = $purchaseItem;
            $purchaseItem->setPurchase($this);
        }

        return $this;
    }

    public function removePurchaseItem(PurchaseItem $purchaseItem): self
    {
        if ($this->purchaseItems->contains($purchaseItem)) {
            $this->purchaseItems->removeElement($purchaseItem);
            // set the owning side to null (unless already changed)
            if ($purchaseItem->getPurchase() === $this) {
                $purchaseItem->setPurchase(null);
            }
        }

        return $this;
    }

    public function addItemsFromCart(Cart $cart): void
    {
        foreach ($cart->getItems() as $item) {
            $this->addPurchaseItem($item->createPurchaseItem());
        }
    }

    public function getTotal(): int
    {
        return array_reduce($this->purchaseItems->toArray(), fn($accumulator, PurchaseItem $item): int|float => $accumulator + $item->getTotal(), 0);
    }

    public function getTotalString(): string
    {
        return (string) ($this->getTotal() / 100);
    }
}
