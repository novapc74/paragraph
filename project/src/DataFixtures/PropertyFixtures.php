<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertyFixtures extends BaseFixture implements DependentFixtureInterface
{
    private const PROPERTY_TITLE = [
        'Страна производства',
        'Вид застежки',
        'Ширина предмета',
        'Высота предмета',
        'Длина упаковки',
        'Высота упаковки',
        'Ширина упаковки',
        'Материал изделия',
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Property::class, 8, function (Property $property, $count) {
            $property
                ->setTitle(self::PROPERTY_TITLE[$count])
                ->setPosition($count);
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }
}
