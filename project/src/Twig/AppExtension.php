<?php

namespace App\Twig;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\SocialNetworkRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private const REMOVABLE_CHAR = ['+', '(', ')', ' ', '  ', '-'];

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

    public function getFilters(): array
    {
        return [
            new TwigFilter('filterPhoneMask', [$this, 'removePhoneMask']),
        ];
    }

    public function removePhoneMask(string $string): string
    {
        return str_replace(self::REMOVABLE_CHAR, '', $string);
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