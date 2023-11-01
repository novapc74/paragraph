<?php

namespace App\Entity;

use App\Entity\Trait\HasMediaInterface;
use App\Entity\Trait\HasMediaTrait;
use App\Enum\PageBlockType;
use App\Repository\PageBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

#[ORM\Entity(repositoryClass: PageBlockRepository::class)]
class PageBlock implements HasMediaInterface
{
    use HasMediaTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $html = null;

    #[ORM\ManyToOne(targetEntity: Media::class, cascade: ['persist'])]
    private ?Media $image = null;

    #[ORM\OneToMany(mappedBy: 'pageBlock', targetEntity: Gallery::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $Gallery;

    #[ORM\ManyToOne]
    private ?Product $product = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ArrayShape([
        'Продукт' => 'string',
        'Интерьер' => 'string',
    ])]
    public static function getAvailableType(string $type = null): array|string
    {
        $data = [
            'Продукт' => PageBlockType::product_block_type->name,
            'Интерьер' => PageBlockType::interior_block_type->name,
        ];

        return $type ? array_flip($data)[$type] : $data;
    }

    public function __construct()
    {
        $this->Gallery = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getHtml(): ?string
    {
        return $this->html;
    }

    public function setHtml(?string $html): static
    {
        $this->html = $html;

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(?Media $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Gallery>
     */
    public function getGallery(): Collection
    {
        return $this->Gallery;
    }

    public function addGallery(Gallery $gallery): static
    {
        if (!$this->Gallery->contains($gallery)) {
            $this->Gallery->add($gallery);
            $gallery->setPageBlock($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): static
    {
        if ($this->Gallery->removeElement($gallery)) {
            // set the owning side to null (unless already changed)
            if ($gallery->getPageBlock() === $this) {
                $gallery->setPageBlock(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public static function allMediaFields(): array
    {
        return ['image'];
    }

    public function getNewImage(): ?Media
    {
        return $this->image;
    }

    public function setNewImage(?Media $image): self
    {
        $this->uploadNewMedia($image, 'image');

        return $this;
    }
}
