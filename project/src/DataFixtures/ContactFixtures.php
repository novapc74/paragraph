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
                ->setPhone(['+7 (980) 144-27-72'])
                ->setAddress('140406 Московская обл., г. Коломна, Окский проспект, 76')
                ->setInn('7714384027')
                ->setCoordinates('55.071169, 38.799046');
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
