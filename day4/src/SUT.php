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

    public function runCommand(string $command): string
    {
        $command = $this->parseCommand($command);
        $this->flipSwitches($command);
        return $this->generateMicrocontrollerCommand();
    }

    private function generateMicrocontrollerCommand(): string
    {
        return '';
    }

    /**
     * @deprecated
     */
    private function calculateOn(): int
    {
        $lights_on = 0;
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < 1000; $j++) {
                    $lights_on += $this->grid[$i][$j];
            }
        }

        return $lights_on;
    }

    private function parseCommand(string $command): Command
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

        return new Command($operation, $x1, $y1, $x2, $y2);
    }

    private function flipSwitches(Command $command): void
    {
        for ($i = $command->x1; $i <= $command->x2; $i++) {
            for ($j = $command->y1; $j <= $command->y2; $j++) {
                if ($command->operation == 'on')
                    $this->grid[$i][$j] = 1;
                else
                    $this->grid[$i][$j] = 0;
            }
        }
    }
}
