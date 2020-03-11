<?php

namespace spec;

use Exception;
use game;
use PhpSpec\ObjectBehavior;

class gameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(game::class);
    }

    function it_throws_exception_on_invalid_roll()
    {
        $this->roll(5);
        $this->shouldThrow(Exception::class)->duringRoll(8);
    }

    function it_should_roll()
    {
        $this->roll(1);
    }

    function it_scores_correct_after_gutter_Game()
    {
        $this->rollMany(20, 0);
        $this->score()->shouldReturn(0);
    }

    function it_scores_correct_after_all_ones()
    {
        $this->rollMany(20, 1);
        $this->score()->shouldReturn(20);
    }


    function it_scores_correct_after_one_spare()
    {
        $this->rollSpare();
        $this->roll(3);
        $this->rollMany(17, 0);
        $this->score()->shouldReturn(16);
    }

    function it_scores_correct_after_one_strike()
    {
        $this->roll(10);
        $this->roll(3);
        $this->roll(4);

        $this->rollMany(16, 0);
        $this->score()->shouldReturn(24);
    }

    function it_has_10th_frame_functionality()
    {
        $this->rollMany(19, 0);
        $this->roll(10);
        $this->roll(10);
        $this->score()->shouldReturn(20);
    }

    function it_passses_complicated_game()
    {
        $this->rollArray([3, 5, 10, 10, 5, 2, 1, 5, 6, 3, 0, 0, 0, 0, 0, 0, 10, 5, 2]);
        $this->score()->shouldReturn(89);
    }

    function it_wont_allow_out_of_game_rolls()
    {
        $this->rollMany(19, 0);
        $this->roll(3); //Game Ends

        $this->roll(10);
        $this->score()->shouldReturn(3);
    }

    private function rollMany($rolls, $pins)
    {
        for ($i = 1; $i <= $rolls; $i++) {
            $this->roll($pins);
        }
    }

    private function rollArray(array $rolls)
    {
        foreach ($rolls as $roll) {
            $this->roll($roll);
        }
    }

    private function rollSpare()
    {
        $this->roll(5);
        $this->roll(5);
    }
}
