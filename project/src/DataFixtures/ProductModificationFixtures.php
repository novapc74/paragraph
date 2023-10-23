<?php

namespace App\DataFixtures;

use App\Entity\ProductModification;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductModificationFixtures extends BaseFixture implements DependentFixtureInterface
{

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(ProductModification::class, 6, function (ProductModification $productModification, $count) {
            $productModification
                ->setProduct($this->getReference('Product_0'))
                ->setColor($this->getReference("Color_$count"));
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            ColorFixtures::class,
        ];
    }
}
