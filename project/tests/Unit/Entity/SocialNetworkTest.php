<?php

namespace App\Tests\Unit\Entity;

use App\Entity\SocialNetwork;
use PHPUnit\Framework\TestCase;

class SocialNetworkTest extends TestCase
{
    public function testCanCreateAndUpdate(): void
    {
        $socialNetwork = (new SocialNetwork())
            ->setName('ozone')
            ->setLink('https://ozone.ru/test');

        self::assertSame('ozone', $socialNetwork->getName());
    }

}