<?php

namespace GameOfLife\WorldReader;

use Exception;

class CellOutOfWorldException extends Exception
{

    public static function byPositions(int $positionX, int $positionY): self
    {
        return new self(sprintf("Cell [%d,%d] is out of world", $positionX, $positionY));
    }

}
