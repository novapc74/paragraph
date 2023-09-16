<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ContactFixtures extends BaseFixture implements FixtureGroupInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Contact::class, 1, function (Contact $contact) {
            $contact
                ->setTitle('ООО Пром-Стандарт')
                ->setEmail('email@test.com')
                ->setPhone(['+7 (812) 363-01-08', '+7 (812) 363-01-09'])
                ->setAddress('Санкт-Петербург пл. Карла Фаберже, 8')
                ->setInn('6546376172')
                ->setCoordinates('59.939864, 30.314565');
        });

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return [
            SocialNetworkFixtures::class
        ];
    }
}
