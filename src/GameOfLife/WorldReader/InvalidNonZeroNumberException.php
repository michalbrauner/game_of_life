<?php

namespace GameOfLife\WorldReader;

use Exception;

class InvalidNonZeroNumberException extends Exception
{

    public static function byValue(string $value): self
    {
        return new self(sprintf("Invalid non-zero number: '%s'.", $value));
    }

}
