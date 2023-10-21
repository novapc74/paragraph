<?php

namespace App\Entity;

use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\PositionTrait;
use App\Repository\PropertyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    use IdentifierTrait, PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: PropertyGroup::class, cascade: ['persist'], inversedBy: 'properties')]
    private ?PropertyGroup $propertyGroup = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? 'новое свойство';
    }

    public function getPropertyGroup(): ?PropertyGroup
    {
        return $this->propertyGroup;
    }

    public function setPropertyGroup(?PropertyGroup $propertyGroup): static
    {
        $this->propertyGroup = $propertyGroup;

        return $this;
    }
}
