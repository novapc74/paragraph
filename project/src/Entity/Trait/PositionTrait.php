<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait PositionTrait
{
    #[ORM\Column]
    private ?int $position = null;

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