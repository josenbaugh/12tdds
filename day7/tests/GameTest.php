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
    public function cannot_play_game_with_less_than_2_players(): void
    {
        $game = new Game();
        $game->add('Vader');

        $this->expectException(\Exception::class);
        $game->roll(rand(0,5) + 1);
    }

    /**
     * @test
     */
    public function players_can_get_out_of_jail(): void
    {
        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');

        $game->roll(2);
        $game->wasCorrectlyAnswered(); //vader gets a coin

        $game->roll(1);
        $game->wrongAnswer(); //maul goes to the penalty box
        self::assertTrue($game->inPenaltyBox[1]);

        $game->roll(2);
        $game->wasCorrectlyAnswered(); //vader gets a coin

        $game->roll(1); //odd roll gets maul out

        self::assertFalse($game->inPenaltyBox[0]);
        self::assertFalse($game->inPenaltyBox[1]);
    }
}
