<?php

namespace App\Entity;

use App\Entity\Trait\IdentifierTrait;
use App\Repository\ColorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    use IdentifierTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $hex = null;

    #[ORM\Column]
    private ?int $position = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
     return $this->getTitle() ?? 'новый цвет';
    }

    public function getHex(): ?string
    {
        return $this->hex;
    }

    public function setHex(string $hex): static
    {
        $this->hex = $hex;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }
}
