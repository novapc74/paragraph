<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Review;
use App\Entity\Contact;
use App\Entity\Product;
use App\Enum\ReviewOnPage;
use App\Entity\PropertyGroup;
use App\Entity\ProductPropertyValue;
use App\Repository\ReviewRepository;
use App\Repository\ContactRepository;
use Twig\Extension\AbstractExtension;
use App\Repository\PropertyGroupRepository;
use App\Repository\SocialNetworkRepository;

class AppExtension extends AbstractExtension
{
    private const REMOVABLE_CHAR = ['+', '(', ')', ' ', '  ', '-'];

    public function __construct(private readonly ContactRepository       $contactRepository,
                                private readonly SocialNetworkRepository $socialNetworkRepository,
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
            new TwigFunction('reviewPageCount', [$this, 'getReviewPageCount']),
        ];
    }

    public function getReviewPageCount(): int
    {
        $reviews = $this->reviewRepository->findAll();
        if ($count = count($reviews)) {
            $data = $count / ReviewOnPage::REVIEW_ON_ONE_PAGE->value;

            return $data < 1 ? 1 : ceil($data);
        }

        return 0;
    }

    public function getRating(): float
    {
        $reviews = $this->reviewRepository->findAll();

        if ($reviewCount = count($reviews)) {
            $ratingCollection = array_map(fn(Review $review) => $review->getRating(), $reviews);

            return round(array_sum($ratingCollection) / $reviewCount, 1);
        }

        return 0;
    }

    public function getPropertyGroups(Product $product): array
    {
        $propertyGroups = [];

        array_map(
            function (PropertyGroup $group) use (&$propertyGroups, $product) {
                $propertyGroups[$group->getTitle()] = array_filter(
                    $product->getProductProperties()->toArray(),
                    fn(ProductPropertyValue $productPropertyValue) => $productPropertyValue->getProduct() === $product && $productPropertyValue->getProductProperty()->getPropertyGroup() === $group);
            },
            $this->propertyGroupRepository->findByProduct($product)
        );

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