<?php

namespace App\Entity;

use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\PositionTrait;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    use IdentifierTrait, PositionTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->getTitle() ?? 'новая категория';
    }
}
