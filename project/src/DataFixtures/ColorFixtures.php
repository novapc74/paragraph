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
            'title' => 'Темно-синий',
            'modernTitle' => 'blu notte',
            'slug' => 'blue',
            'hex' => '#00007e'
        ],
        [
            'title' => 'Винно-красный',
            'slug' => 'burgundy',
            'hex' => '#9b2d30',
            'modernTitle' => 'bordeaux',
        ],
        [
            'title' => 'Капучино',
            'slug' => 'beige',
            'hex' => '#c0987e',
            'modernTitle' => 'kraft',
        ],
        [
            'title' => 'Натурально-белый',
            'slug' => 'white',
            'hex' => '#FFFFFF',
            'modernTitle' => 'neve',
        ],
        [
            'title' => 'Антрацит',
            'slug' => 'anthracite',
            'hex' => '#666666',
            'modernTitle' => 'anthracite',
        ],
        [
            'title' => 'Темно-коричневый',
            'slug' => 'dark_brown',
            'hex' => '#573120',
            'modernTitle' => 'dark brown',
        ],
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Color::class, 7, function (Color $color, $count) {
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
