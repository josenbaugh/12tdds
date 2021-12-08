<?php

namespace tdd;

class SUT
{
    public function __construct()
    {
    }

    public function sweep(array $input): array
    {
        $output = $input;
        
        for ($i = 0; $i < count($output); $i++) {
            for ($j = 0; $j < count($output[$i]); $j++) {
                if ($output[$i][$j] != '*')
                    $output[$i][$j] = 0;
            }
        }

        for ($i = 0; $i < count($output); $i++) {
            for ($j = 0; $j < count($output[$i]); $j++) {
                if ($output[$i][$j] == '*')
                    $output = $this->incrementAdjcent($output, $i, $j);
            }
        }

        return $output;
    }

    private function incrementAdjcent(array $in, int $row, int $col): array
    {
        $rows = count($in)-1;
        $cols = count($in[0])-1;

        if ($row-1 >= 0 && $col-1 >= 0 && $in[$row-1][$col-1] != '*')
            $in[$row-1][$col-1] += 1;
        if ($row+1 <= $rows && $col+1 <= $cols && $in[$row+1][$col+1] != '*')
            $in[$row+1][$col+1] += 1;
        if ($row-1 >= 0 && $col+1 <= $cols && $in[$row-1][$col+1] != '*')
            $in[$row-1][$col+1] += 1;
        if ($row+1 <= $rows && $col-1 >= 0 && $in[$row+1][$col-1] != '*')
            $in[$row+1][$col-1] += 1;
        if ($row-1 >= 0 && $in[$row-1][$col] != '*')
            $in[$row-1][$col] += 1;
        if ($row+1 <= $rows && $in[$row+1][$col] != '*')
            $in[$row+1][$col] += 1;
        if ($col+1 <= $cols && $in[$row][$col+1] != '*')
            $in[$row][$col+1] += 1;
        if ($col-1 >= 0 && $in[$row][$col-1] != '*')
            $in[$row][$col-1] += 1;

        return $in;
    }
}
