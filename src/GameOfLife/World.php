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

    }

}
