<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Persistence\ObjectManager;

class ColorFixtures extends BaseFixture
{
    private const COLOR_DATA = [
        [
            'title' => 'Черный',
            'modernTitle' => 'NERO',
            'slug' => 'black',
            'hex' => '#000000'
        ],
        [
            'title' => 'Синий',
            'modernTitle' => 'BLUE NOTE',
            'slug' => 'blue',
            'hex' => '#0000FF'
        ],
        [
            'title' => 'Красный',
            'slug' => 'red',
            'hex' => '#FF0000',
            'modernTitle' => 'BORDEAUX',
        ],
        [
            'title' => 'Темно-лососевый',
            'slug' => 'dark-salmon',
            'hex' => '#E9967A',
            'modernTitle' => 'KRAFT',
        ],
        [
            'title' => 'Темно-оранжевый',
            'slug' => 'dark-orange',
            'hex' => '#FF8C00',
            'modernTitle' => 'NERO',
        ],
        [
            'title' => 'Белый',
            'slug' => 'white',
            'hex' => '#FFFFFF',
            'modernTitle' => 'NEVE',
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
