<?php

namespace App\Entity;

use App\Repository\ProductPropertyValueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductPropertyValueRepository::class)]
class ProductPropertyValue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'productProperties')]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'productPropertyValues')]
    private ?Property $productProperty = null;

    private ?string $country = null;
    private ?string $measure = null;

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getMeasure(): string
    {
        return $this->measure;
    }

    public function setMeasure(string $measure): static
    {
        $this->measure = $measure;

        return $this;
    }

    #[ORM\PreFlush]
    public function prePersist(): void
    {
        if ($this->measure && $this->value) {
            $this->value = "{$this->value} {$this->measure}";
        }

        elseif ($this->country) {
            $this->value = $this->country;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return "{$this->productProperty}: {$this->value}";
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getProductProperty(): ?Property
    {
        return $this->productProperty;
    }

    public function setProductProperty(?Property $productProperty): static
    {
        $this->productProperty = $productProperty;

        return $this;
    }


}
