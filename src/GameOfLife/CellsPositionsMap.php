<?php

namespace GameOfLife;

use Generator;

class CellsPositionsMap
{

    private $cellsPositionsMap = [];

    /**
     * @param array $positions
     */
    public function __construct(array $positions)
    {
        foreach ($positions as $position) {
            $this->addCellPosition($position[0], $position[1]);
        }
    }

    /**
     * @param int $positionX
     * @param int $positionY
     */
    public function addCellPosition(int $positionX, int $positionY): void
    {
        if (!isset($this->cellsPositionsMap[$positionX])) {
            $this->cellsPositionsMap[$positionX] = [];
        }

        if (!isset($this->cellsPositionsMap[$positionX][$positionY])) {
            $this->cellsPositionsMap[$positionX][$positionY] = true;
        }
    }

    /**
     * @param int $positionX
     * @param int $positionY
     * @return bool
     */
    public function positionExists(int $positionX, int $positionY): bool
    {
        return isset($this->cellsPositionsMap[$positionX]) && isset($this->cellsPositionsMap[$positionX][$positionY]);
    }

    /**
     * @return Generator|int[]
     */
    public function getCellsPositions(): Generator
    {
        foreach ($this->cellsPositionsMap as $positionX => $xData) {
            foreach ($xData as $positionY => $yData) {
                yield [$positionX, $positionY];
            }
        }
    }

}
