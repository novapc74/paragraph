<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager): void
    {
        $this->createEntity(Product::class, 1, function (Product $product) {
            $product
                ->setTitle('Nero')
                ->setShortDescription('Элегантный вертикальный накопитель А4 из 2-мм картона с дизайнерской обложкой. Организация и стиль в одном.')
                ->setFullDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad deserunt dolorem dolores ea ipsam libero minima optio perspiciatis quod, sit. Beatae consequuntur deleniti deserunt fugit ipsa minus quia quod sunt!')
                ->setCategory($this->getReference('Category_0'));

            $product->addStore($this->getReference('Store_0'));
            $product->addStore($this->getReference('Store_1'));
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            StoreFixtures::class,
        ];
    }
}
