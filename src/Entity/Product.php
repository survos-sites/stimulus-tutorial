<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: \App\Repository\ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    #[Groups('product:read')]
    private ?int $id = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[Groups(['product:read','searchable'])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::TEXT, nullable: true)]
    #[Groups(['product:read','searchable'])]
    private ?string $description = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 120)]
    #[Assert\NotBlank]
    private string $brand = 'Low End Luxury';

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::FLOAT, nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    #[Groups('product:read')]
    #[Assert\GreaterThan(0)]
    #[Assert\NotBlank]
    private ?int $price = null;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::INTEGER)]
    #[Assert\GreaterThanOrEqual(0)]
    private ?int $stockQuantity = 0;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: \App\Entity\Category::class, inversedBy: 'products')]
    #[Assert\NotBlank]
    private ?\App\Entity\Category $category = null;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, \App\Entity\Color>
     */
    #[ORM\ManyToMany(targetEntity: \App\Entity\Color::class)]
    private \Doctrine\Common\Collections\Collection $colors;

    #[ORM\Column(type: \Doctrine\DBAL\Types\Types::STRING, length: 255)]
    #[Assert\NotBlank]
    private ?string $imageFilename = 'floppy-disc.png';

    #[ORM\Column(nullable: true)]
    private ?bool $isFeatured = null;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getPriceString(): string
    {
        return (string) ($this->price / 100);
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(int $stockQuantity): self
    {
        $this->stockQuantity = $stockQuantity;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Color[]
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Color $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
        }

        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->colors->contains($color)) {
            $this->colors->removeElement($color);
        }

        return $this;
    }

    public function hasColors(): bool
    {
        return count($this->colors) > 0;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(string $imageFilename): self
    {
//        if (!str_starts_with($imageFilename, 'http')) {
//            $imageFilename = '/uploads/products/' . $imageFilename;
//        }
        $this->imageFilename = $imageFilename; // featured products are stored in /assets and always available

        return $this;
    }

    #[Groups('product:read')]
    public function getImageUrl(): string
    {
        return $this->imageFilename; // really the url
    }

    public function isIsFeatured(): ?bool
    {
        return $this->isFeatured;
    }

    public function setIsFeatured(?bool $isFeatured): static
    {
        $this->isFeatured = $isFeatured;

        return $this;
    }
}
