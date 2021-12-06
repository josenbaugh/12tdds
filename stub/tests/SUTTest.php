<?php

namespace Tests;

use Generator;
use PHPUnit\Framework\TestCase;
use tdd\SUT;

require __DIR__ . '/../vendor/autoload.php';

class SUTTest extends TestCase
{
    /**
     * @test
    */
    public function method_does_thing(): void
    {
        self::assertSame(0, 0);
    }
}
