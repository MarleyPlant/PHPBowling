<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use game;

class gameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(game::class);
    }

    function it_should_roll(){
        $this->beConstructedWith();
        $this->roll(1);
    }

    function it_should_return_score(){
        $this->beConstructedWith();
        $this->roll(1);

        $this->score()->shouldReturn(1);
    }

    function it_scores_correct_after_gutter_Game(){
        $this->beConstructedWith();
        $this->rollMany(20, 0);
        $this->score()->shouldReturn(0);
    }

    function it_scores_correct_after_all_ones(){
        $this->beConstructedWith();
        $this->rollMany(20,1);
        $this->score()->shouldReturn(20);
    }


    function it_scores_correct_after_one_spare(){
        $this->rollSpare();
        $this->rollSpare();
        $this->rollSpare();
        $this->rollMany(17,0);
        $this->score()->shouldReturn(16);
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
    }
}
