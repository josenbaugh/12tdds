<?php

namespace tdd;

class GameState
{
    const SETUP = 'setup';
    const ROLL = 'roll';
    const GUESS  = 'guess';

    private $next_state = [
        self::SETUP => self::ROLL,
        self::ROLL => self::GUESS,
        self::GUESS => self::ROLL,
    ];

    private $state = self::SETUP;

    public function getCurrentState(): string
    {
        return $this->state;
    }

    public function next(): void
    {
        $this->state = $this->next_state[$this->state];
    }
}
