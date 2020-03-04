<?php

namespace spec;

use game;
use PhpSpec\ObjectBehavior;

class gameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(game::class);
    }

    function it_should_roll()
    {
        $this->beConstructedWith();
        $this->roll(1);
    }

    function it_scores_correct_after_gutter_Game()
    {
        $this->beConstructedWith();
        $this->rollMany(20, 0);
        $this->score()->shouldReturn(0);
    }

    function it_scores_correct_after_all_ones()
    {
        $this->beConstructedWith();
        $this->rollMany(20, 1);
        $this->score()->shouldReturn(20);
    }


    function it_scores_correct_after_one_spare()
    {
        $this->beConstructedWith();
        $this->rollSpare();
        $this->roll(3);
        $this->rollMany(17, 0);
        $this->score()->shouldReturn(16);
    }

    function it_scores_correct_after_one_strike()
    {
        $this->beConstructedWith();
        $this->roll(10);
        $this->roll(3);
        $this->roll(4);

        $this->rollMany(16, 0);
        $this->score()->shouldReturn(24);
    }

    function it_has_10th_frame_functionality()
    {
        $this->beConstructedWith();
        $this->rollMany(19, 0);
        $this->roll(10);
        $this->roll(10);
        $this->score()->shouldReturn(20);
    }

    function complicated_game()
    {
        $this->beConstructedWith();

    }

    private function rollMany($rolls, $pins)
    {
        for ($i = 1; $i <= $rolls; $i++) {
            $this->roll($pins);
        }
    }

    private function rollSpare()
    {
        $this->roll(5);
        $this->roll(5);
    }
}
