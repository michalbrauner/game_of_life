<?php

namespace GameOfLife;

class World
{

    /**
     * @var Grid
     */
    private $grid;

    public function __construct(int $initialSizeX, int $initialSizeY, CellsPositionsMap $aliveCellsPositions)
    {
        $this->grid = new Grid($initialSizeX, $initialSizeY, $aliveCellsPositions);
    }

    public function run(int $numberOfIterations)
    {
        for ($iteration = 1; $iteration <= $numberOfIterations; $iteration++) {
            $this->updateGrid();
        }
    }

    private function updateGrid(): void
    {
        foreach ($this->grid->getCells() as $cell) {
            $aliveNeighbours = $this->grid->getAliveNeighbours($cell->getPositionX(), $cell->getPositionY());

            $cell->updateStateForNextIteration(count($aliveNeighbours));
        }
    }

    public function getGrid(): Grid
    {
        return $this->grid;
    }

}
