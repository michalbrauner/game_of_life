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
        $this->grid = new Grid($initialSizeX, $initialSizeY);
    }

    /**
     * @param int $numberOfIterations
     */
    public function run(int $numberOfIterations)
    {
        for ($iteration = 1; $iteration <= $numberOfIterations; $iteration++) {
            $this->grid->getCells()->rewind();

            foreach ($this->grid->getCells() as $cell) {
                $cell->updateStateForNextIteration(
                    $this->grid->getAliveNeighbours($cell->getPositionX(), $cell->getPositionX())
                );
            }
        }
    }



}
