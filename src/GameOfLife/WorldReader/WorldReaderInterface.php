<?php

namespace GameOfLife\WorldReader;

use GameOfLife\World;

interface WorldReaderInterface
{

    public function load(): World;

}
