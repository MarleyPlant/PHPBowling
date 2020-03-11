<?php

use Exceptions\InvalidRoll;

class game
{
    const SPARE          = 5;
    const STRIKE         = 10;
    const SPARE_BONUS    = 10;
    const MAX_FRAMES     = 10;
    const PINS_PER_FRAME = 10;

    private int   $currentRoll;

    private int   $indexOfFirstFrame;

    private int   $maxRolls;

    private array $rolls;

    public function __construct()
    {
        $this->rolls       = array_fill(0, 22, 0);
        $this->currentRoll = 0;
        $this->maxRolls    = 20;
    }

    /** @throws Exception */
    public function roll(int $pins)
    {
        $isSpare     = $pins == self::SPARE;
        $isStrike    = $pins == self::STRIKE;
        $isLastRolls = $this->currentRoll >= 19;

        if ($this->isInvalidRoll($pins)) {
            throw InvalidRoll::withPins($pins);
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

    public function score(): int
    {
        $score                   = 0;
        $this->indexOfFirstFrame = 0;

        for ($frame = 0; $frame < self::MAX_FRAMES; $frame++) {
            $score += $this->scoreFrame();
        }

        return $score;
    }

    private function addRoll(int $pins): void
    {
        $this->rolls[$this->currentRoll++] = $pins;
    }

    private function isSecondFrame(): bool
    {
        return 1 == ($this->currentRoll % 2);
    }

    private function isSpare(): bool
    {
        return $this->rolls[$this->indexOfFirstFrame] + $this->rolls[1 + $this->indexOfFirstFrame] ==
            self::PINS_PER_FRAME;
    }

    private function isStrike(): bool
    {
        return $this->rolls[$this->indexOfFirstFrame] == self::STRIKE;
    }

    private function isInvalidRoll(int $pins): bool
    {
        if (!$this->isSecondFrame()) {
            return false;
        }

        if (0 == $this->currentRoll) {
            return false;
        }

        $lastRoll = $this->rolls[$this->currentRoll - 1];
        if ($lastRoll == self::STRIKE) {
            return false;
        }

        return ($lastRoll + $pins) > 10;
    }

    private function nextBall()
    {
        return $this->rolls[$this->indexOfFirstFrame++] + $this->rolls[$this->indexOfFirstFrame++];
    }

    private function nextBallForSpare(): int
    {
        $this->indexOfFirstFrame += 2;

        return $this->rolls[$this->indexOfFirstFrame];
    }

    private function nextBallForStrike(): int
    {
        return $this->rolls[1 + $this->indexOfFirstFrame++] + $this->rolls[1 + $this->indexOfFirstFrame];
    }

    /**
     * @return int|mixed
     */
    private function scoreFrame()
    {
        if ($this->isStrike()) {
            return $this->scoreStrike();
        }
        if ($this->isSpare()) {
            return $this->scoreSpare();
        }

        return $this->scoreNextBall();
    }

    /**
     * @return mixed
     */
    private function scoreNextBall(): int
    {
        return $this->nextBall();
    }

    /**
     * @return int
     */
    private function scoreSpare(): int
    {
        return self::SPARE_BONUS + $this->nextBallForSpare();
    }

    /**
     * @return int
     */
    private function scoreStrike(): int
    {
        return self::STRIKE + $this->nextBallForStrike();
    }

}
