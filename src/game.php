<?php

class game
{
    private array $rolls;
    private int $currentRoll;
    private int $maxRolls;

    function __construct()
    {
        $this->rolls = array(0, 22);
        $this->currentRoll = 0;
        $this->maxRolls = 20;
    }

    public function roll($pins)
    {
        $isSpare = $pins == 5;
        $isStrike = $pins == 10;
        $isLastRolls = $this->currentRoll > 19;

        if ($this->currentRoll < $this->maxRolls) {
            $this->addRoll($pins);
            $this->currentRoll++;
        } else if ($isStrike && $isLastRolls) {
            $this->addRoll($pins);
            $this->maxRolls += 2;
            $this->currentRoll++;
        } else if ($isSpare && $isLastRolls) {
            $this->addRoll($pins);
            $this->maxRolls += 1;
            $this->currentRoll++;
        }
    }

    public function score()
    {
        $score = 0;
        $indexofFirstFrame = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($indexofFirstFrame)) {
                $score += 10 + $this->nextBallForStrike($indexofFirstFrame);
                $indexofFirstFrame++;
            } else if ($this->isSpare($indexofFirstFrame)) {
                $score += 10 + $this->nextBallForSpare($indexofFirstFrame);
                $indexofFirstFrame += 2;
            } else {
                $score += $this->nextBall($indexofFirstFrame);
                $indexofFirstFrame += 2;
            }
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


    /**
     * @param int $indexofFirstFrame
     * @return int|mixed
     */
    private function nextBallForStrike(int $indexofFirstFrame)
    {
        return $this->rolls[$indexofFirstFrame + 1] + $this->rolls[$indexofFirstFrame + 2];
    }


    private function nextBallForSpare(int $indexofFirstFrame)
    {
        return $this->rolls[$indexofFirstFrame + 2];
    }

    private function nextBall(int $indexofFirstFrame)
    {
        return $this->rolls[$indexofFirstFrame] + $this->rolls[$indexofFirstFrame + 1];
    }

    /**
     * @param $pins
     */
    private function addRoll($pins): void
    {
        $this->rolls[$this->currentRoll] = $pins;
    }

}
