<?php

use GameOfLife\CellsPositionsMap;
use GameOfLife\World;

require __DIR__ . '/vendor/autoload.php';

$world = new World(5, 5, new CellsPositionsMap([]));
$world->run(2);

echo 'test';
