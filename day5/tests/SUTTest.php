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
            'on 0:0-2:2'     => 'off/0-2,1000-1002,2000-2002',
            'off 1:1-3:3'    => 'off/0-2,1000-1000,2000-2000',
            'on 0:0-999:999' => 'on/',
            'off 0:0-2:2'    => 'on/0-2,1000-1002,2000-2002',
            'on 1:1-3:3'     => 'on/0-2,1000-1000,2000-2000',
        ];


        $sut = new SUT();

        foreach ($expect as $command => $expected) {
            self::assertSame($expected, $sut->runCommand($command));
        }
    }
}
