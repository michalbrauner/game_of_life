<?php

use GameOfLife\World;

require __DIR__ . '/vendor/autoload.php';

$world = new World(10, 10);
$world->run(5);
