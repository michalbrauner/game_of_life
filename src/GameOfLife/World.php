<?php

namespace GameOfLife;

class World
{

    /**
     * @var Grid
     */
    private $grid;

    /**
     * @param int $initialSizeX
     * @param int $initialSizeY
     */
    public function __construct(int $initialSizeX, int $initialSizeY)
    {
        $this->grid = new Grid($initialSizeX, $initialSizeY, new CellsPositionsMap([]));
    }

    /**
     * @param int $numberOfIterations
     */
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

}
