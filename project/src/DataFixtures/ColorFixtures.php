<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Persistence\ObjectManager;

class ColorFixtures extends BaseFixture
{
    private const COLOR_DATA = [
        [
            'title' => 'Черный',
            'modernTitle' => 'nero',
            'slug' => 'black',
            'hex' => '#000000'
        ],
        [
            'title' => 'Синий',
            'modernTitle' => 'blu notte',
            'slug' => 'blue',
            'hex' => '#0000FF'
        ],
        [
            'title' => 'Бордовый',
            'slug' => 'burgundy',
            'hex' => '#9B2D30',
            'modernTitle' => 'bordeaux',
        ],
        [
            'title' => 'Бежевый',
            'slug' => 'beige',
            'hex' => '#F5F5DC',
            'modernTitle' => 'kraft',
        ],
        [
            'title' => 'Белый',
            'slug' => 'white',
            'hex' => '#FFFFFF',
            'modernTitle' => 'neve',
        ],
        [
            'title' => 'Антрацит',
            'slug' => 'anthracite',
            'hex' => '#45464С',
            'modernTitle' => 'anthracite',
        ],
        [
            'title' => 'Темно-коричневый',
            'slug' => 'dark_brown',
            'hex' => '#654321',
            'modernTitle' => 'dark brown',
        ],
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Color::class, 6, function (Color $color, $count) {
            $color
                ->setTitle(self::COLOR_DATA[$count]['title'])
                ->setModernTitle(self::COLOR_DATA[$count]['modernTitle'])
                ->setSlug(self::COLOR_DATA[$count]['slug'])
                ->setHex(self::COLOR_DATA[$count]['hex'])
                ->setPosition($count);
        });

        $manager->flush();
    }
}
