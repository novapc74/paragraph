<?php

namespace App\DataFixtures;

use App\Entity\SocialNetwork;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class SocialNetworkFixtures extends BaseFixture implements FixtureGroupInterface
{
    private const SOCIAL_NETWORK_DATA = [
        [
            'name' => 'telegram',
            'link' => 'https://telegram.com',
        ],
        [
            'name' => 'vk',
            'link' => 'https://vk.com',
        ], [
            'name' => 'whatsapp',
            'link' => 'https://www.whatsapp.com',
        ],
    ];

    public function loadData(ObjectManager $manager): void
    {
        $this->createEntity(SocialNetwork::class, 3, function (SocialNetwork $socialNetwork, $count) {
            $socialNetwork
                ->setName(self::SOCIAL_NETWORK_DATA[$count]['name'])
                ->setLink(self::SOCIAL_NETWORK_DATA[$count]['link']);
        });

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
