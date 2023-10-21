<?php

namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends BaseFixture
{
    private const CATEGORY_DATA = [
        'Категория A', 'Категория B', 'Категория C'
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Category::class, 3, function (Category $category, $count) {
            $category
                ->setTitle(self::CATEGORY_DATA[$count])
                ->setPosition($count);
        });

        $manager->flush();
    }
}
