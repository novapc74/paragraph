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
                ->setTitle('Вертикальный накопитель "Paragraph"')
                ->setDescription('Элегантный вертикальный накопитель А4 из 2-мм картона с дизайнерской обложкой. Организация и стиль в одном.<-#%#->Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad deserunt dolorem dolores ea ipsam libero minima optio perspiciatis quod, sit. Beatae consequuntur deleniti deserunt fugit ipsa minus quia quod sunt!');
        });

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            StoreFixtures::class,
            ColorFixtures::class,
        ];
    }
}
