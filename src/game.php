<?php

class game
{
    private array $rolls = array(0);
    private int $currentRoll;

    function __construct()
    {
        $this->rolls = [];
        $this->currentRoll = 0;
    }

    public function roll($pins)
    {
            $this->rolls[$this->currentRoll] = $pins;
            $this->currentRoll++;
    }

    public function score()
    {
        $score = 0;
        $indexofFirstFrame = 0;
        for ($frame=0; $frame<=10; $frame++){
            $score += $this->rolls[$indexofFirstFrame++] + $this->rolls[$indexofFirstFrame + 1];
            $indexofFirstFrame += 2;
        }
    }
}
