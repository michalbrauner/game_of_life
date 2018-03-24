<?php

namespace GameOfLife\WorldWriter;

use GameOfLife\CellsPositionsMap;
use GameOfLife\Grid;

interface WorldWriterInterface
{

    public function save(int $sizeX, int $sizeY, Grid $grid, CellsPositionsMap $cellsPositionsMap);

}
