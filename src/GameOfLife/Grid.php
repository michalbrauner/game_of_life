<?php

namespace GameOfLife;

use Generator;

class Grid
{

    /**
     * @var array
     */
    private $grid = [];

    /**
     * @param int $sizeX
     * @param int $sizeY
     * @param array $aliveCellsMap
     */
    public function __construct(int $sizeX, int $sizeY, array $aliveCellsMap)
    {
        $this->createGrid($sizeX, $sizeY, $aliveCellsMap);
    }

    /**
     * @param int $x
     * @param int $y
     * @param array $aliveCellsMap
     */
    private function createGrid(int $x, int $y, array $aliveCellsMap): void
    {
        if ($x == 0 || $y == 0) {
            return;
        }

        for ($positionX = 0; $positionX < $x; $positionX++) {
            $this->grid[$positionX] = [];

            for ($positionY = 0; $positionY < $y; $positionY++) {
                $cellState = isset($aliveCellsMap[$positionX]) && isset($aliveCellsMap[$positionX][$positionY])
                    ? CellInterface::STATE_ALIVE
                    : CellInterface::STATE_DEAD;

                $this->grid[$positionX][$positionY] = new Cell($cellState, $positionX, $positionY);
            }
        }
    }

    /**
     * @return Generator|CellInterface[]
     */
    public function getCells(): Generator
    {
        foreach ($this->grid as $itemsOnXLine) {
            foreach ($itemsOnXLine as $cell) {
                yield $cell;
            }
        }
    }

    /**
     * @param int $x
     * @param int $y
     * @return Generator|CellInterface[]
     */
    public function getAliveNeighbours(int $x, int $y): Generator
    {
        $coordinatesOfNeighbours = $this->getCoordinatesOfNeighbours($x, $y);

        foreach ($coordinatesOfNeighbours as $coordinate) {
            $coordinateX = $coordinate[0];
            $coordinateY = $coordinate[1];

            if (isset($this->grid[$coordinateX]) && isset($this->grid[$coordinateX][$coordinateY])) {

                /** @var CellInterface $cell */
                $cell = $this->grid[$coordinateX][$coordinateY];

                if ($cell->isAlive()) {
                    yield $this->grid[$coordinateX][$coordinateY];
                }
            }
        }
    }

    /**
     * @param int $x
     * @param int $y
     * @return array
     */
    private function getCoordinatesOfNeighbours(int $x, int $y): array
    {
        return [
            [$x - 1, $y - 1],
            [$x, $y - 1],
            [$x + 1, $y - 1],
            [$x - 1, $y],
            [$x + 1, $y],
            [$x - 1, $y + 1],
            [$x, $y + 1],
            [$x + 1, $y + 1],
        ];
    }

}
