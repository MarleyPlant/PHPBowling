<?php

class game
{
    private array $rolls;
    private int $currentRoll;

    function __construct()
    {
        $this->rolls = array(0, 20);
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

        for ($frame=0; $frame<10; $frame++){

            if($this->isStrike($indexofFirstFrame)){
                $score += 10 + $this->rolls[$indexofFirstFrame+1] + $this->rolls[$indexofFirstFrame + 2];
            }
            else if ($this->isSpare($indexofFirstFrame)){
                $score += 10 + $this->rolls[$indexofFirstFrame+2];
            }
            else {
                $score += $this->rolls[$indexofFirstFrame] + $this->rolls[$indexofFirstFrame+1]   ;
            }
            $indexofFirstFrame += 2;
        }
        return $score;

    }

    /**
     * @param int $indexofFirstFrame
     * @return bool
     */
    private function isSpare(int $indexofFirstFrame): bool
    {
        return $this->rolls[$indexofFirstFrame] + $this->rolls[$indexofFirstFrame + 1] == 10;
    }

    /**
     * @param int $indexofFirstFrame
     * @return bool
     */
    private function isStrike(int $indexofFirstFrame): bool
    {
        return $this->rolls[$indexofFirstFrame] == 10;
    }

}
