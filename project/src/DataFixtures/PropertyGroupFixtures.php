<?php

namespace App\DataFixtures;

use App\Entity\PropertyGroup;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PropertyGroupFixtures extends BaseFixture implements DependentFixtureInterface
{
    private const PROPERTY_GROUP_TITLE = [
        'Дополнительная информация',
        'Габариты',
        'Материалы',
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(PropertyGroup::class, 3, function (PropertyGroup $propertyGroup, $count) {

            switch ((int)$count) {
                case 0:
                    $propertyGroup->addProperty($this->getReference('Property_0'));
                    $propertyGroup->addProperty($this->getReference('Property_1'));
                    break;
                case 1:
                    $propertyGroup->addProperty($this->getReference('Property_2'));
                    $propertyGroup->addProperty($this->getReference('Property_3'));
                    $propertyGroup->addProperty($this->getReference('Property_4'));
                    $propertyGroup->addProperty($this->getReference('Property_5'));
                    $propertyGroup->addProperty($this->getReference('Property_6'));
                    break;
                case 2:
                    $propertyGroup->addProperty($this->getReference('Property_7'));
                    break;
            }
//            if ($count === 0) {
//                $propertyGroup->addProperty($this->getReference('Property_0'));
//                $propertyGroup->addProperty($this->getReference('Property_1'));
//            }
//
//            if ($count === 1) {
//                $propertyGroup->addProperty($this->getReference('Property_2'));
//                $propertyGroup->addProperty($this->getReference('Property_3'));
//                $propertyGroup->addProperty($this->getReference('Property_4'));
//                $propertyGroup->addProperty($this->getReference('Property_5'));
//                $propertyGroup->addProperty($this->getReference('Property_6'));
//            }
//
//            if ($count === 2) {
//                $propertyGroup->addProperty($this->getReference('Property_7'));
//            }

            $propertyGroup
                ->setTitle(self::PROPERTY_GROUP_TITLE[$count])
                ->setPosition($count);
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PropertyFixtures::class
        ];
    }
}
