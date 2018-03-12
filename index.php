<?php

use GameOfLife\World;

require __DIR__ . '/vendor/autoload.php';

$world = new World(5, 5);
$world->run(2);
