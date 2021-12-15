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

        self::assertFalse($game->inPenaltyBox[1]);
    }

    /**
     * @test
     */
    public function cannot_add_players_after_first_roll(): void
    {
        $this->expectException(\Exception::class);

        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');
        $game->roll(2);
        $game->add('Palpatine');
    }

    /**
     * @test
     */
    public function cannot_roll_twice(): void
    {
        $this->expectException(\Exception::class);

        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');
        $game->roll(2);
        $game->roll(2);
    }

    /**
     * @test
     */
    public function cannot_answer_correct_twice(): void
    {
        $this->expectException(\Exception::class);

        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');
        $game->roll(2);
        $game->wasCorrectlyAnswered();
        $game->wasCorrectlyAnswered();
    }

    /**
     * @test
     */
    public function cannot_answer_wrong_twice(): void
    {
        $this->expectException(\Exception::class);

        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');
        $game->roll(2);
        $game->wrongAnswer();
        $game->wrongAnswer();
    }
}
