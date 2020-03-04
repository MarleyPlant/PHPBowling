<?php

class Frame
{
    private int $firstroll;
    private int $secondRoll;

    function __construct() {

    }

    public function roll($pin) {
        if ($this->firstroll != null){
            $this->firstroll = $pin;
        }
        else {
            $this->secondRoll = $pin;
        }
    }

    public function score()
    {
        if ($this->firstroll + $this->secondRoll == 10) {
            return 10;
        }

        return $this->firstroll + $this->secondRoll;
    }
}
