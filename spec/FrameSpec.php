<?php

namespace spec;

use Frame;
use PhpSpec\ObjectBehavior;

class FrameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Frame::class);
    }

    function let()
    {
        $this->beConstructedWith(5, 5);
    }

    function it_should_return_score(){
        $this->score()->shouldReturn(10);
    }
}
