<?php

class game
{
    private array $rolls;
    private int $currentRoll;
    private int $maxRolls;

    function __construct()
    {
        $this->rolls = array_fill(0, 22, 0);
        $this->currentRoll = 0;
        $this->maxRolls = 20;
    }

    public function roll($pins)
    {
        $isSpare = $pins == 5;
        $isStrike = $pins == 10;
        $isLastRolls = $this->currentRoll > 19;

        if (!$this->isValidRoll($pins)) {
            throw new Exception("Invalid Roll");
        }

        if ($this->currentRoll < $this->maxRolls) {
            $this->addRoll($pins);
            return;
        }
        if ($isStrike && $isLastRolls) {
            $this->addRoll($pins);
            $this->maxRolls += 2;
            return;
        }
        if ($isSpare && $isLastRolls) {
            $this->addRoll($pins);
            $this->maxRolls++;
            return;
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
        $this->rolls[$this->currentRoll++] = $pins;
    }

    /**
     * @return bool
     */
    private function isSecondFrame(): bool
    {
        return 1 == ($this->currentRoll % 2);
    }

    /**
     * @param $pins
     * @return bool
     */
    private function isValidRoll($pins): bool
    {
        if (!$this->isSecondFrame()) {
            return true;
        }

        if (!$this->currentRoll > 0) {
            return true;
        }

        $lastRoll = $this->rolls[$this->currentRoll - 1];
        if ($lastRoll == 10) {
            return true;
        }

        return ($lastRoll + $pins) <= 10;
    }

}
