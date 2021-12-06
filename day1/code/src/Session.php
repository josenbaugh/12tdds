<?php

namespace tdd;

class Session implements SessionInterface
{
    /**
     * @var int[]
     */
    private array $jobs;

    public function __construct()
    {
        $this->jobs = [];
    }
    
    public function addJobs(int ...$jobs): void
    {
        $this->jobs = \array_merge($this->jobs, $jobs);
    }

    public function getSessionStats(): SessionStats
    {
        return new SessionStats(
            $this->getMinimum(),
            $this->getMaximum(),
            $this->getCount(),
            $this->getAverage()
        );
    }

    private function getMinimum(): int
    {
        return ! empty($this->jobs) ? \min($this->jobs) : 0;
    }

    private function getMaximum(): int
    {
        return ! empty($this->jobs) ? \max($this->jobs) : 0;
    }

    private function getCount(): int
    {
        return \count($this->jobs);
    }

    private function getAverage(): float
    {
        return ! empty($this->jobs) ? \round(\array_sum($this->jobs) / \count($this->jobs), 2) : 0;
    }
}
