<?php

namespace App\Entity;

use App\Entity\Trait\CacheMediaPathTrait;
use App\Repository\ProductModificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

//#[ORM\Entity(repositoryClass: ProductModificationRepository::class)]
class ProductModification
{
//	use CacheMediaPathTrait;
//
//	#[ORM\Id]
//	#[ORM\GeneratedValue]
//	#[ORM\Column]
//	private ?int $id = null;
//
//	#[ORM\ManyToOne]
//	private ?Color $color = null;
//
//	#[ORM\OneToMany(mappedBy: 'productModification', targetEntity: Gallery::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
//	private Collection $gallery;
//
//	#[ORM\ManyToOne(targetEntity: Product::class, cascade: ['persist'], inversedBy: 'modifications')]
//	private ?Product $product = null;
//
//	public function __construct()
//	{
//		$this->gallery = new ArrayCollection();
//	}
//
//	#[Groups(['modification:item'])]
//	#[SerializedName('images')]
//	public function getGalleryCollection(): array
//	{
//		return array_map(fn(Gallery $gallery) => [
//			'color' => $this->getColor()->getTitle(),
//			'image' => $this->getMediaCachePath($gallery->getImage()),
//		], $this->getGallery()->toArray());
//	}
//
//	public function __toString(): string
//	{
//		return $this?->getColor()->getTitle() ?? 'новая модификация';
//	}
//
//	public function getId(): ?int
//	{
//		return $this->id;
//	}
//
//	public function getColor(): ?Color
//	{
//		return $this->color;
//	}
//
//	public function setColor(?Color $color): static
//	{
//		$this->color = $color;
//
//		return $this;
//	}
//
//	/**
//	 * @return Collection<int, Gallery>
//	 */
//	public function getGallery(): Collection
//	{
//		return $this->gallery;
//	}
//
//	public function addGallery(Gallery $gallery): static
//	{
//		if (!$this->gallery->contains($gallery)) {
//			$this->gallery->add($gallery);
//			$gallery->setProductModification($this);
//		}
//
//		return $this;
//	}
//
//	public function removeGallery(Gallery $gallery): static
//	{
//		if ($this->gallery->removeElement($gallery)) {
//			// set the owning side to null (unless already changed)
//			if ($gallery->getProductModification() === $this) {
//				$gallery->setProductModification(null);
//			}
//		}
//
//		return $this;
//	}
//
//	public function getProduct(): ?Product
//	{
//		return $this->product;
//	}
//
//	public function setProduct(?Product $product): static
//	{
//		$this->product = $product;
//
//		return $this;
//	}
}
