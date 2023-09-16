<?php

namespace App\Twig;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\SocialNetworkRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function __construct(private readonly ContactRepository       $contactRepository,
                                private readonly SocialNetworkRepository $socialNetworkRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('contact', [$this, 'getContact']),
            new TwigFunction('socialNetworks', [$this, 'getSocialNetworks']),
        ];
    }

    public function getContact(): ?Contact
    {
        return $this->contactRepository->findOneBy([]);
    }

    public function getSocialNetworks(): array
    {
        return $this->socialNetworkRepository->findAll();
    }
}