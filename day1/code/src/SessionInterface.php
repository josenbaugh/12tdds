<?php

namespace tdd;

interface SessionInterface
{
    public function addJobs(int ...$jobs): void;
    public function getSessionStats(): SessionStats;
}
