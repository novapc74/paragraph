<?php

namespace App\Entity\Trait;

interface ExplodeDescriptionInterface
{
    public function getDescription(): string;

    public function setDescription(string $description): static;
}