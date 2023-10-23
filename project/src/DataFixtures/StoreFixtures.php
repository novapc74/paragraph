<?php

namespace App\DataFixtures;


use App\Entity\Store;
use Doctrine\Persistence\ObjectManager;

class StoreFixtures extends BaseFixture
{
    private const STORE_DATA = [
        [
            'title' => 'ozone',
            'link' => 'www.ozone.ru/product/nero'
        ],
        [
            'title' => 'wb',
            'link' => 'www.wb.ru/product/nero'
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
