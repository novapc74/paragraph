<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Review;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\PropertyGroup;
use App\Entity\ProductPropertyValue;
use App\Repository\ReviewRepository;
use App\Repository\ContactRepository;
use App\Repository\ProductRepository;
use Twig\Extension\AbstractExtension;
use App\Repository\PropertyGroupRepository;
use App\Repository\SocialNetworkRepository;

class AppExtension extends AbstractExtension
{
    private const REMOVABLE_CHAR = ['+', '(', ')', ' ', '  ', '-'];

    public function __construct(private readonly ContactRepository       $contactRepository,
                                private readonly SocialNetworkRepository $socialNetworkRepository,
                                private readonly ProductRepository       $productRepository,
                                private readonly PropertyGroupRepository $propertyGroupRepository,
                                private readonly ReviewRepository        $reviewRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('contact', [$this, 'getContact']),
            new TwigFunction('socialNetworks', [$this, 'getSocialNetworks']),
            new TwigFunction('propertyGroups', [$this, 'getPropertyGroups']),
            new TwigFunction('rating', [$this, 'getRating']),
        ];
    }

    public function getRating(): float
    {
        $reviews = $this->reviewRepository->findAll();
        $reviewCount = count($reviews);
        $ratingCollection = array_map(fn(Review $review) => $review->getRating(), $reviews);

        return round(array_sum($ratingCollection) / $reviewCount, 1);
    }

    public function getPropertyGroups(Product $product): array
    {
        $propertyGroups = [];
        if ($product = $this->productRepository->findOneBy([])) {

            array_map(
                function (PropertyGroup $group) use (&$propertyGroups, $product) {
                    $propertyGroups[$group->getTitle()] = array_filter(
                        $product->getProductProperties()->toArray(),
                        fn(ProductPropertyValue $productPropertyValue) => $productPropertyValue->getProduct() === $product && $productPropertyValue->getProductProperty()->getPropertyGroup() === $group);
                },
                $this->propertyGroupRepository->findByProduct($product)
            );
        }

        return $propertyGroups;
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