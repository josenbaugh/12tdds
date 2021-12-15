<?php

namespace tdd;

use Generator;
use PHPUnit\Framework\TestCase;
use tdd\GameState;

require __DIR__ . '/../vendor/autoload.php';

class GameStateTest extends TestCase
{
    /**
     * @test
     */
    public function getCurrentState_maintains_expected_state(): void
    {
        $state = new GameState();

        self::assertSame(GameState::SETUP, $state->getCurrentState());
        $state->next();

        foreach (range(1, 10) as $i) {
            self::assertSame(GameState::ROLL, $state->getCurrentState());
            $state->next();

            self::assertSame(GameState::GUESS, $state->getCurrentState());
            $state->next();
        }
    }
}
