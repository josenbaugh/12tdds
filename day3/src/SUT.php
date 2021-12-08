<?php

namespace tdd;

class SUT
{
    /**
     * @var int[]
     */
    private $grid;

    public function __construct()
    {
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                    $this->grid[$i][$j] = 0;
            }
        }
    }

    public function runCommand(string $command): int
    {
        $command = \explode(' ', $command);
        $operation = $command[0];
        $coordinates = \explode('-', $command[1]);
        $p1 = \explode(':', $coordinates[0]);
        $p2 = \explode(':', $coordinates[1]);
        $x1 = $p1[0];
        $y1 = $p1[1];
        $x2 = $p2[0];
        $y2 = $p2[1];

        for ($i = $x1; $i <= $x2; $i++) {
            for ($j = $y1; $j <= $y2; $j++) {
                if ($operation == 'on')
                    $this->grid[$i][$j] = 1;
                else
                    $this->grid[$i][$j] = 0;
            }
        }
        
        $lights_on = 0;
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                    $lights_on += $this->grid[$i][$j];
            }
        }

        return $lights_on;
    }
}
