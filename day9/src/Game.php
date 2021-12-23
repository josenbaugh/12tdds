<?php

namespace tdd;

use tdd\exceptions\CannotAddPlayersException;
use tdd\exceptions\CannotAnswerException;
use tdd\exceptions\CannotRollException;
use tdd\exceptions\NeedMorePlayersException;

const ECHO_OUT = false;

class Game {
    var $players;
    var $places;
    var $purses ;
    var $inPenaltyBox;

    var $popQuestions;
    var $scienceQuestions;
    var $sportsQuestions;
    var $rockQuestions;

    var $currentPlayer = 0;
    var $isGettingOutOfPenaltyBox;

    private GameState $game_state;

    function  __construct() {
        $this->game_state = new GameState();

        $this->players = array();
        $this->places = array(0);
        $this->purses  = array(0);
        $this->inPenaltyBox  = array(0);

        $this->popQuestions = array();
        $this->scienceQuestions = array();
        $this->sportsQuestions = array();
        $this->rockQuestions = array();

        for ($i = 0; $i < 50; $i++) {
            array_push($this->popQuestions, "Pop Question " . $i);
            array_push($this->scienceQuestions, "Science Question " . $i);
            array_push($this->sportsQuestions, "Sports Question " . $i);
            array_push($this->rockQuestions, "Rock Question " . $i);
        }
    }

    function echoln($string) {
        if (ECHO_OUT)
            echo $string."\n";
    }

	function isPlayable() {
		return ($this->howManyPlayers() >= 2);
	}

	function add($playerName) {
        if ($this->game_state->getCurrentState() !== GameState::SETUP)
            throw new CannotAddPlayersException('You cannot add new players after the game has begun');

        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        $this->echoln($playerName . " was added");
        $this->echoln("They are player number " . count($this->players));
        return true;
	}

	function howManyPlayers() {
		return count($this->players);
	}

	function roll($roll) {
        if (!$this->isPlayable())
            throw new NeedMorePlayersException('Need more players!');

        if ($this->game_state->getCurrentState() === GameState::SETUP)
            $this->game_state->next();

        if ($this->game_state->getCurrentState() !== GameState::ROLL)
            throw new CannotRollException('You cannot roll at this time!');

        $this->echoln($this->players[$this->currentPlayer] . " is the current player");
        $this->echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                $this->isGettingOutOfPenaltyBox = true;
                $this->echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");

                $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
                if ($this->places[$this->currentPlayer] > 11)
                    $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

                $this->echoln($this->players[$this->currentPlayer]
                    . "'s new location is "
                    .$this->places[$this->currentPlayer]);
                $this->echoln("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                $this->echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
                $this->isGettingOutOfPenaltyBox = false;
            }

        } else {
            $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
            if ($this->places[$this->currentPlayer] > 11)
                $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;

            $this->echoln($this->players[$this->currentPlayer]
                . "'s new location is "
                .$this->places[$this->currentPlayer]);
            $this->echoln("The category is " . $this->currentCategory());
            $this->askQuestion();
        }

        if ($this->isGettingOutOfPenaltyBox) {
            $this->inPenaltyBox[$this->currentPlayer] = false;
            $this->isGettingOutOfPenaltyBox = false;
        } else if ($this->inPenaltyBox[$this->currentPlayer]) {
            $this->game_state->next();
        }

        $this->game_state->next();
	}

	function askQuestion() {
		if ($this->currentCategory() == "Pop")
			$this->echoln(array_shift($this->popQuestions));
		if ($this->currentCategory() == "Science")
			$this->echoln(array_shift($this->scienceQuestions));
		if ($this->currentCategory() == "Sports")
			$this->echoln(array_shift($this->sportsQuestions));
		if ($this->currentCategory() == "Rock")
			$this->echoln(array_shift($this->rockQuestions));
	}

	function currentCategory() {
		if ($this->places[$this->currentPlayer] == 0) return "Pop";
		if ($this->places[$this->currentPlayer] == 4) return "Pop";
		if ($this->places[$this->currentPlayer] == 8) return "Pop";
		if ($this->places[$this->currentPlayer] == 1) return "Science";
		if ($this->places[$this->currentPlayer] == 5) return "Science";
		if ($this->places[$this->currentPlayer] == 9) return "Science";
		if ($this->places[$this->currentPlayer] == 2) return "Sports";
		if ($this->places[$this->currentPlayer] == 6) return "Sports";
		if ($this->places[$this->currentPlayer] == 10) return "Sports";
		return "Rock";
	}
    
    function answer(bool $correct)
    {
        if ($this->game_state->getCurrentState() !== GameState::GUESS)
            throw new CannotAnswerException('You cannot answer at this time!');
        
        if ($correct)
            $return = $this->wasCorrectlyAnswered();
        else
            $return = $this->wrongAnswer();

        $this->game_state->next();

        return $return;
    }

	function wasCorrectlyAnswered() {
        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($this->isGettingOutOfPenaltyBox) {
                $this->echoln("Answer was correct!!!!");
                $this->purses[$this->currentPlayer]++;
                $this->echoln($this->players[$this->currentPlayer]
                    . " now has "
                    .$this->purses[$this->currentPlayer]
                    . " Gold Coins.");

                $winner = $this->didPlayerWin();
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players))
                    $this->currentPlayer = 0;

                return $winner;
            } else {
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players))
                    $this->currentPlayer = 0;
                return true;
            }

        } else {
            $this->echoln("Answer was correct!!!!");
            $this->purses[$this->currentPlayer]++;
            $this->echoln($this->players[$this->currentPlayer]
                . " now has "
                .$this->purses[$this->currentPlayer]
                . " Gold Coins.");

            $winner = $this->didPlayerWin();
            $this->currentPlayer++;
            if ($this->currentPlayer == count($this->players)) $this->currentPlayer = 0;

            return $winner;
        }
	}

	function wrongAnswer() {
        $this->echoln("Question was incorrectly answered");
        $this->echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players))
            $this->currentPlayer = 0;
        return true;
	}


	function didPlayerWin() {
		return !($this->purses[$this->currentPlayer] == 6);
	}
}
