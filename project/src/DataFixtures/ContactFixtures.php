<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Contact::class, 1, function (Contact $contact) {
            $contact
                ->setTitle('ООО "Пром-Стандарт"')
                ->setEmail('paragraph-home@mail.ru')
                ->setPhone(['+7 (999) 777-66-66'])
                ->setAddress('Москва, ул. Вятская, д. 70')
                ->setInn('7714384027')
                ->setCoordinates('55.802341, 37.582125');
        });

        $manager->flush();
    }

    public function getDependencies(): array

    {
        return [
            SocialNetworkFixtures::class
        ];
    }
}
