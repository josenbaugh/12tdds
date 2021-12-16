<?php

namespace tdd;

use Generator;
use PHPUnit\Framework\TestCase;
use tdd\exceptions\CannotAddPlayersException;
use tdd\exceptions\CannotAnswerException;
use tdd\exceptions\CannotRollException;
use tdd\exceptions\NeedMorePlayersException;
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

        $this->expectException(NeedMorePlayersException::class);
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
        $game->answer(true); //vader gets a coin

        $game->roll(1);
        $game->answer(false); //maul goes to the penalty box
        self::assertTrue($game->inPenaltyBox[1]);

        $game->roll(2);
        $game->answer(true); //vader gets a coin

        $game->roll(1); //odd roll gets maul out

        self::assertFalse($game->inPenaltyBox[1]);
    }

    /**
     * @test
     */
    public function cannot_add_players_after_first_roll(): void
    {
        $this->expectException(CannotAddPlayersException::class);

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
        $this->expectException(CannotRollException::class);

        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');
        $game->roll(2);
        $game->roll(2);
    }

    /**
     * @test
     * @testWith [false, false]
     *           [false, true]
     *           [true, false]
     *           [true, true]
     */
    public function cannot_answer_twice(bool $answer1, bool $answer2): void
    {
        $this->expectException(CannotAnswerException::class);

        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');
        $game->roll(2);
        $game->answer($answer1);
        $game->answer($answer2);
    }

    /**
     * @test
     */
    public function when_players_fail_the_get_out_of_jail_roll_they_should_not_answer(): void
    {
        $game = new Game();
        $game->add('Vader');
        $game->add('Maul');

        $game->roll(2);
        $game->answer(true); //vader gets a coin

        $game->roll(1);
        $game->answer(false); //maul goes to the penalty box
        self::assertTrue($game->inPenaltyBox[1]);

        $game->roll(2);
        $game->answer(true); //vader gets a coin

        $game->roll(1); //odd roll gets maul out

        $game->roll(1); //this would be vader's turn since maul shouldn't answer
    }
}
