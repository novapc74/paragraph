<?php

namespace App\Entity;

use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\PositionTrait;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'productProperty', targetEntity: ProductPropertyValue::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $productPropertyValues;

    public function __construct()
    {
        $this->productPropertyValues = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ProductPropertyValue>
     */
    public function getProductPropertyValues(): Collection
    {
        return $this->productPropertyValues;
    }

    public function addProductPropertyValue(ProductPropertyValue $productPropertyValue): static
    {
        if (!$this->productPropertyValues->contains($productPropertyValue)) {
            $this->productPropertyValues->add($productPropertyValue);
            $productPropertyValue->setProductProperty($this);
        }

        return $this;
    }

    public function removeProductPropertyValue(ProductPropertyValue $productPropertyValue): static
    {
        if ($this->productPropertyValues->removeElement($productPropertyValue)) {
            // set the owning side to null (unless already changed)
            if ($productPropertyValue->getProductProperty() === $this) {
                $productPropertyValue->setProductProperty(null);
            }
        }

        return $this;
    }
}
