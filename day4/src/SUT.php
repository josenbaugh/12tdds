<?php

namespace tdd;

class SUT
{
    /**
     * @var int[][]
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
        return $this->combineSequences($this->getLEDSequence());
    }

    private function combineSequences(array $sequence): string
    {
        print_r($sequence);
        $return = [];
        $part_seq = [];
        for ($i = 1; $i < \count($sequence); $i++) {
            if ($sequence[$i] === $sequence[$i-1]+1) {
                $part_seq[] = $sequence[$i-1];
                $part_seq[] = $sequence[$i];
            } else {
                if ($part_seq === []) {
                    $return[] = (string)$sequence[$i];
                } else {
                    $c = \count($part_seq)-1;
                    $return[] = (string)$part_seq[0] . '-' . (string)$part_seq[$c];
                    $part_seq = [];
                }
            }
        }

        // if ($part_seq !== []) {
        //     $c = \count($part_seq)-1;
        //     $return[] = (string)$part_seq[0] . '-' . (string)$part_seq[$c];
        //     $part_seq = [];
        // }

        return \implode(',', $return);
    }

    private function getLEDSequence(): array
    {
        $out = [];
        for ($i = 0; $i < 1000; $i++) {
            $on = \array_keys($this->grid[$i], 1, true);
            foreach ($on as $led) {
                $out[] = $led + ($i*1000);
            }
        }

        return $out;
    }

    private function calculateOn(): int
    {
        return count($this->getLEDSequence());
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
