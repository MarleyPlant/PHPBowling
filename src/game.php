<?php

class game
{
    private array $rolls = array(0, 20, 0);
    private int $currentRoll;

    function __construct()
    {
        $this->rolls = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
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
            $indexOfSecondFrame = $indexofFirstFrame + 1;

            $score += ($this->rolls[$indexofFirstFrame] + $this->rolls[$indexOfSecondFrame]);
            $indexofFirstFrame += 2;
        }
        return $score;

    }
}
