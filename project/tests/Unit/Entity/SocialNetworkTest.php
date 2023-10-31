<?php

namespace App\Tests\Unit\Entity;

use App\Entity\SocialNetwork;
use Generator;
use PHPUnit\Framework\TestCase;

class SocialNetworkTest extends TestCase
{
    /**
     * @dataProvider titleProvider
     */
    public function testCanCreateAndUpdate($title, $link): void
    {
        $socialNetwork = (new SocialNetwork())
            ->setName($title)
            ->setLink($link);

        self::assertSame($title, $socialNetwork->getName(), 'а тут описание теста, ждем полного совпадения');
        self::assertSame($link, $socialNetwork->getLink(), 'а тут описание теста, ждем полного совпадения');
    }

    public function titleProvider(): Generator
    {
        yield 'OZONE title' => ['ozone', 'https://ozone.ru/test'];
        yield 'WB title' => ['wb', '123.ru'];
    }
}