<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixture implements DependentFixtureInterface
{

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Category::class, 1, function (Category $category) {
            $category
                ->setTitle('Paragraph')
                ->addProduct($this->getReference('Product_0'));

        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductFixtures::class
        ];
    }
}
