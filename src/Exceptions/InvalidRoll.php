<?php

namespace Exceptions;

class InvalidRoll extends \RuntimeException
{
    public static function withPins(int $pins)
    {
        return new self(sprintf('Invalid roll %s', $pins));
    }
}
