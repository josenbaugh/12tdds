<?php

namespace tdd;

class GameState
{
    const SETUP = 'setup';
    const ROLL = 'roll';
    const GUESS  = 'guess';

    public function getCurrentState(): string
    {
        return '';
    }

    public function next(): void
    {
    }
}
