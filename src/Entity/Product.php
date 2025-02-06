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
    #[ORM\Column(type: 'integer')]
    #[Groups('product:read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['product:read','searchable'])]
    #[Assert\NotBlank]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['product:read','searchable'])]
    private $description;

    #[ORM\Column(type: 'string', length: 120)]
    #[Assert\NotBlank]
    private $brand = 'Low End Luxury';

    #[ORM\Column(type: 'float', nullable: true)]
    private $weight;

    #[ORM\Column(type: 'integer')]
    #[Groups('product:read')]
    #[Assert\GreaterThan(0)]
    #[Assert\NotBlank]
    private $price;

    #[ORM\Column(type: 'integer')]
    #[Assert\GreaterThanOrEqual(0)]
    private $stockQuantity = 0;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: \App\Entity\Category::class, inversedBy: 'products')]
    #[Assert\NotBlank]
    private $category;

    #[ORM\ManyToMany(targetEntity: \App\Entity\Color::class)]
    private $colors;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $imageFilename = 'floppy-disc.png';

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
