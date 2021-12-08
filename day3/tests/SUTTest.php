<?php

namespace tdd;

use PHPUnit\Framework\TestCase;
use tdd\SUT;

require __DIR__ . '/../vendor/autoload.php';

class SUTTest extends TestCase
{
    /**
     * @test
    */
    public function runCommand_gives_expected_output(): void
    {
        $expect = [
            'on 0:0-2:2'  => 9,
            'off 1:1-3:3' => 5,
            'on 0:4-9:4'  => 15,
            'on 4:0-4:9'  => 24,
            'off 3:3-4:4' => 21,
            'on 1:1-1:1'  => 22,
            'on 0:0-4:4'  => 35,
            'off 0:0-9:9' => 0,
        ];

        $sut = new SUT();

        foreach ($expect as $command => $expected) {
            self::assertSame($expected, $sut->runCommand($command));
        }
    }
}
