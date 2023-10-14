<?php

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends BaseFixture implements DependentFixtureInterface
{
    private const REVIEW_NAME = ['Илья', 'Марина', 'Дима', 'Валя', 'Женя'];

    public function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Review::class, 5, function (Review $review, $count) {
            $review
                ->setTitle(self::REVIEW_NAME[$count])
                ->setSubTitle('ОЧЕНЬ КАЧЕСТВЕННЫЙ МАТЕРИАЛ')
                ->setDescription('Очень качественный, приятный на ощупь материал. Проверил при приемке - ничего не надорвано, все целое. Цена, конечно, кусачая, но вещь крутая.')
                ->setRating(rand(1, 5));
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ContactFixtures::class,
        ];
    }
}
