<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductRepository;
use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\CacheMediaPathTrait;
use Doctrine\Common\Collections\Collection;
use App\Entity\Trait\ExplodeDescriptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Trait\ExplodeDescriptionInterface;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product implements ExplodeDescriptionInterface
{
    use IdentifierTrait, ExplodeDescriptionTrait, CacheMediaPathTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sku = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductPropertyValue::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $productProperties;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Gallery::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $gallery;

    #[ORM\ManyToOne(targetEntity: self::class, cascade: ['persist'], inversedBy: 'childProducts')]
    private ?self $parentProduct = null;

    #[ORM\OneToMany(mappedBy: 'parentProduct', targetEntity: self::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $childProducts;

    #[ORM\ManyToOne(targetEntity: Color::class, cascade: ['persist'])]
    private ?Color $color = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Store::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $marketPlaces;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['persist'], inversedBy: 'products')]
    private ?Category $category = null;

    public function __construct()
    {
        $this->productProperties = new ArrayCollection();
        $this->gallery = new ArrayCollection();
        $this->childProducts = new ArrayCollection();
        $this->marketPlaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getTitle() . ' - ' . $this?->getColor()?->getTitle() ?? 'новый продукт';
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
     * @return Collection<int, ProductPropertyValue>
     */
    public function getProductProperties(): Collection
    {
        return $this->productProperties;
    }

    public function addProductProperty(ProductPropertyValue $productProperty): static
    {
        if (!$this->productProperties->contains($productProperty)) {
            $this->productProperties->add($productProperty);
            $productProperty->setProduct($this);
        }

        return $this;
    }

    public function removeProductProperty(ProductPropertyValue $productProperty): static
    {
        if ($this->productProperties->removeElement($productProperty)) {
            // set the owning side to null (unless already changed)
            if ($productProperty->getProduct() === $this) {
                $productProperty->setProduct(null);
            }
        }

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

    public function getParentProduct(): ?self
    {
        return $this->parentProduct;
    }

    public function setParentProduct(?self $parentProduct): static
    {
        $this->parentProduct = $parentProduct;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildProducts(): Collection
    {
        return $this->childProducts;
    }

    public function addChildProduct(self $childProduct): static
    {
        if (!$this->childProducts->contains($childProduct)) {
            $this->childProducts->add($childProduct);
            $childProduct->setParentProduct($this);
        }

        return $this;
    }

    public function removeChildProduct(self $childProduct): static
    {
        if ($this->childProducts->removeElement($childProduct)) {
            // set the owning side to null (unless already changed)
            if ($childProduct->getParentProduct() === $this) {
                $childProduct->setParentProduct(null);
            }
        }

        return $this;
    }

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Store>
     */
    public function getMarketPlaces(): Collection
    {
        return $this->marketPlaces;
    }

    public function addMarketPlace(Store $marketPlace): static
    {
        if (!$this->marketPlaces->contains($marketPlace)) {
            $this->marketPlaces->add($marketPlace);
            $marketPlace->setProduct($this);
        }

        return $this;
    }

    public function removeMarketPlace(Store $marketPlace): static
    {
        if ($this->marketPlaces->removeElement($marketPlace)) {
            // set the owning side to null (unless already changed)
            if ($marketPlace->getProduct() === $this) {
                $marketPlace->setProduct(null);
            }
        }

        return $this;
    }

    #[ORM\PreFlush]
    public function preFlush(): void
    {
        if ($parentProduct = $this->getParentProduct()) {
            $this->title = $parentProduct->getTitle();
            $this->description = $parentProduct->getDescription();
        }
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
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setProduct($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProduct() === $this) {
                $review->setProduct(null);
            }
        }

        return $this;
    }

}
