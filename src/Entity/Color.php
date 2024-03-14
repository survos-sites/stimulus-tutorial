<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: \App\Repository\ColorRepository::class)]
class Color
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function __construct(#[ORM\Column(type: 'string', length: 100)]
    private string $name, #[ORM\Column(type: 'string', length: 6)]
    private string $hexColor)
    {
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

    public function getHexColor(): ?string
    {
        return $this->hexColor;
    }

    public function setHexColor(string $hexColor): self
    {
        $this->hexColor = $hexColor;

        return $this;
    }

    public function getRed(): string
    {
        return hexdec(substr($this->hexColor, 0, 2));
    }

    public function getGreen(): string
    {
        return hexdec(substr($this->hexColor, 2, 2));
    }

    public function getBlue(): string
    {
        return hexdec(substr($this->hexColor, 4, 2));
    }
}
