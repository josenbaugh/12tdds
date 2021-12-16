Day 8
=====
Consecutive rolls and answers handled, there's another odd behaviour. If a
player is in the penalty box, and they don't roll to get out, they still need
to 'answer' the question to advance the play. This makes little sense and
uses a question when it's not needed.

Task
----
Using the [example code in the language of your choice][1], add failing tests to
assert that:
- a roll that keeps a play in the penalty box advances play automatically

And then make the tests pass.

TDD Tip
-------
You likely have a decent set of tests in place now, so perhaps there are better
ways to maintain state. Do you feel comfortable changing how the state of the 
game is maintained without breaking behaviour? 

[1]: https://github.com/caradojo/trivia

My Thoughts
-----------
Apparently I was thinking ahead yesterday! I already added a new GameState class
to handle the behavior of the flow of the game. This should be pretty
straightforward since that system is already in place. I should be able to just
write a test that displays this behavior and fails, then just call
$game_state->next() when the player fails to get out of the penalty box.

Before that though I just realized that I should break out the exceptions so
that when testing I can be sure I'm getting the correct exception not just any.
