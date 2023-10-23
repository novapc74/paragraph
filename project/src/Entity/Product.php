<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use App\Entity\Trait\IdentifierTrait;
use Doctrine\Common\Collections\Collection;
use App\Entity\Trait\ExplodeDescriptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Trait\ExplodeDescriptionInterface;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product implements ExplodeDescriptionInterface
{
    use IdentifierTrait, ExplodeDescriptionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Gallery::class)]
    private Collection $gallery;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['persist'], inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Store::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $stores;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->stores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? 'новый продукт';
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery->add($gallery);
            $gallery->setProduct($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->gallery->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getProduct() === $this) {
                $gallery->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Store>
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): static
    {
        if (!$this->stores->contains($store)) {
            $this->stores->add($store);
            $store->setProduct($this);
        }

        return $this;
    }

    public function removeStore(Store $store): static
    {
        if ($this->stores->removeElement($store)) {
            // set the owning side to null (unless already changed)
            if ($store->getProduct() === $this) {
                $store->setProduct(null);
            }
        }

        return $this;
    }
}
