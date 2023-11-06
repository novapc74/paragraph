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
                ->setTitle('Вертикальный накопитель')
                ->setDescription('Элегантный вертикальный накопитель А4 из 2-мм картона с дизайнерской обложкой. Организация и стиль в одном.<-#%#->Вертикальный накопитель для бумаг формата А4 ( поставляется в количестве 1 шт, цена указана за 1 шт.), изготовлен из высококачественного полиграфического картона толщиной 2 мм.Оклеен дизайнерской бумагой с тиснением, которая повышает срок службы и придает привлекательный внешний вид и комфортные тактильные ощущения.Накопитель позволяет удобно хранить и сортировать документы, брошюры, каталоги, книги, альбомы и другую бумажную продукцию формата А4.Накопитель поможет организовать пространство на рабочем столе, в шкафу, на полках - как в офисе, так и дома.На лицевой стороне установлена металлическая рамка с этикеткой с возможностью нанесения индивидуальной маркировки..Одно отделение для бумаг.Накопитель поставляется в собранном виде, в количестве 1 шт., упакованным в индивидуальный гофрокороб.

');
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
