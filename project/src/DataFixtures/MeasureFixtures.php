<?php

namespace App\DataFixtures;

use App\Entity\Measure;
use Doctrine\Persistence\ObjectManager;

class MeasureFixtures extends BaseFixture
{
    private const MEASURE_DATA = [
        [
            'title' => 'грамм',
            'value' => 'гр',
        ],
        [
            'title' => 'килограмм',
            'value' => 'кг',
        ],
        [
            'title' => 'миллиметр',
            'value' => 'мм',
        ],
        [
            'title' => 'сантиметр',
            'value' => 'см',
        ],
        [
            'title' => 'метр',
            'value' => 'м',
        ],
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Measure::class, 5, function (Measure $measure, $count) {
            $measure
                ->setTitle(self::MEASURE_DATA[$count]['title'])
                ->setValue(self::MEASURE_DATA[$count]['value']);
        });

        $manager->flush();
    }
}
