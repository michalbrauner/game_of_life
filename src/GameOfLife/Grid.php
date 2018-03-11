<?php

namespace GameOfLife;

class Grid
{

    /**
     * @var array
     */
    private $grid;

    /**
     * @param int $sizeX
     * @param int $sizeY
     */
    public function __construct(int $sizeX, int $sizeY)
    {
        $this->createGrid($sizeX, $sizeY);
    }

    /**
     * @param int $x
     * @param int $y
     * @return CellInterface[]
     */
    public function getNeighbours(int $x, int $y): array
    {
        $neighbours = [];

        $coordinatesOfNeighbours = [
            [$x - 1, $y - 1],
            [$x, $y - 1],
            [$x + 1, $y - 1],
            [$x - 1, $y],
            [$x + 1, $y],
            [$x - 1, $y + 1],
            [$x, $y + 1],
            [$x + 1, $y + 1],
        ];

        foreach ($coordinatesOfNeighbours as $coordinate)
        {
            $coordinateX = $coordinate[0];
            $coordinateY = $coordinate[1];

            if (isset($this->grid[$coordinateX]) && isset($this->grid[$coordinateX][$coordinateY])) {
                $neighbours[] = $this->grid[$coordinateX][$coordinateY];
            }
        }

        return $neighbours;
    }

    /**
     * @param int $x
     * @param int $y
     */
    private function createGrid(int $x, int $y): void
    {
        for ($positionX = 0; $positionX < $x; $positionX++) {
            $this->grid[$positionX] = [];

            for ($positionY = 0; $positionY < $y; $positionY++) {
                $this->grid[$positionX][$positionY] = new Cell(CellInterface::STATE_DEAD, $positionX, $positionY);
            }
        }
    }

}
