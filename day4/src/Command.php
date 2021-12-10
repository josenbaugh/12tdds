<?php

namespace tdd;

class Command
{
    public string $operation;
    public int $x1;
    public int $y1;
    public int $x2;
    public int $y2;

    public function __construct(string $operation, int $x1, int $y1, int $x2, int $y2,)
    {
        $this->operation = $operation;
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }
}
