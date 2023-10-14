<?php

namespace App\DataFixtures;

use App\Entity\SocialNetwork;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SocialNetworkFixtures extends BaseFixture implements DependentFixtureInterface
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

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
