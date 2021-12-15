<?php

namespace tdd;

use Generator;
use PHPUnit\Framework\TestCase;
use tdd\Game;

require __DIR__ . '/../vendor/autoload.php';

class GameTest extends TestCase
{
    /**
     * @test
    */
    public function cannot_play_game_with_lessthan_2_players(): void
    {
        $game = new Game();
        $game->add('Vader');

        $this->expectException(\Exception::class);
        $game->roll(rand(0,5) + 1);
    }
}
