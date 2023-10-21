<?php

namespace App\Entity;

use App\Entity\Trait\IdentifierTrait;
use App\Repository\StoreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
class Store
{
    use IdentifierTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Url]
    #[ORM\Column(length: 255)]
    private ?string $link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? 'новый склад';
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }
}
