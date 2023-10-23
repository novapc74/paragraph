<?php

namespace App\DataFixtures;


use App\Entity\ProductPropertyValue;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProductPropertyValueFixtures extends BaseFixture implements DependentFixtureInterface
{
    private const PROPERTY_VALUE = [
        'Россия',
        'резинка',
        '9 см',
        '37,7 см',
        '32 см',
        '9 см',
        '31 см',
        'картон; Дизайнерская бумага',
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(ProductPropertyValue::class, 8, function (ProductPropertyValue $productPropertyValue, $count) {
            $product = $this->getReference('Product_0');
            $property = $this->getReference("Property_$count");

            $productPropertyValue
                ->setProduct($product)
                ->setProductProperty($property)
                ->setValue(self::PROPERTY_VALUE[$count]);
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class,
            PropertyFixtures::class,
        ];
    }
}
