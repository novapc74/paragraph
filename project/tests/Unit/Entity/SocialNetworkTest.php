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
    public function testCanCreateSocialNetwork($title, $link): void
    {
        $socialNetwork = (new SocialNetwork())
            ->setName($title)
            ->setLink($link);

        $message = 'Ожидается полное совпадение';

        self::assertSame($title, $socialNetwork->getName(), $message);
        self::assertSame($link, $socialNetwork->getLink(), $message);
    }

    public function titleProvider(): Generator
    {
        yield 'OZONE title' => ['ozone', 'https://ozone.ru/test'];
        yield 'WB title' => ['wb', '123.ru'];
    }
}