<?php

namespace App\DataFixtures;


use App\Entity\Store;
use Doctrine\Persistence\ObjectManager;

class StoreFixtures extends BaseFixture
{
    private const STORE_DATA = [
        [
            'title' => 'wb',
            'link' => 'www.wb.ru'
        ],
        [
            'title' => 'ozon',
            'link' => 'www.ozone.ru'
        ],
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Store::class, 2, function (Store $store, $count) {
            $store
                ->setTitle(self::STORE_DATA[$count]['title'])
                ->setLink(self::STORE_DATA[$count]['link']);
        });

        $manager->flush();
    }
}
